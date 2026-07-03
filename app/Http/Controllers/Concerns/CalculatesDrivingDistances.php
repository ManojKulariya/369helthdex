<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Shared road-distance calculation used by the website (FrontController) and
 * the mobile API (ApiController) so both always return the same KM value for
 * the same user location and lab.
 */
trait CalculatesDrivingDistances
{
    /**
     * Road distances (km) from one origin to many destinations via the Google
     * Distance Matrix API, so displayed distances match Google Maps directions.
     *
     * $destinations: ['anyKey' => [lat, lng], ...]
     * Returns:       ['anyKey' => float km | null, ...] — null means "no road
     * distance available, keep the straight-line fallback".
     *
     * Results are cached (config mapdetail.distance_cache_hours, default 24h);
     * failures are cached 10 minutes so an invalid key can't hammer the API.
     * The origin is snapped to a ~110 m grid so tiny GPS jitter reuses cache.
     */
    private function get_driving_distances($originLat, $originLng, array $destinations)
    {
        $results = array_fill_keys(array_keys($destinations), null);

        $apiKey = trim((string) config('mapdetail.key'));
        if ($apiKey === '' || empty($destinations)
            || !is_numeric($originLat) || !is_numeric($originLng)) {
            return $results;
        }

        $originLat = round((float) $originLat, 3);
        $originLng = round((float) $originLng, 3);
        $ttl = max(1, (int) config('mapdetail.distance_cache_hours', 24)) * 3600;

        $cacheKey = function ($dest) use ($originLat, $originLng) {
            return 'hd:dmx:' . $originLat . ',' . $originLng . ':' . $dest[0] . ',' . $dest[1];
        };

        $pending = [];
        foreach ($destinations as $key => $dest) {
            $cached = Cache::get($cacheKey($dest));
            if ($cached !== null) {
                $results[$key] = ($cached === false) ? null : (float) $cached;
            } else {
                $pending[$key] = $dest;
            }
        }
        if (empty($pending)) {
            return $results;
        }

        // The Distance Matrix API accepts up to 25 destinations per request.
        foreach (array_chunk($pending, 25, true) as $chunk) {
            $destParam = implode('|', array_map(function ($d) {
                return $d[0] . ',' . $d[1];
            }, array_values($chunk)));

            $data = null;
            try {
                $response = Http::timeout(5)->get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                    'origins' => $originLat . ',' . $originLng,
                    'destinations' => $destParam,
                    'mode' => 'driving',
                    'key' => $apiKey,
                ]);
                if ($response->successful()) {
                    $data = $response->json();
                } else {
                    Log::warning('Distance Matrix HTTP error ' . $response->status() . ' — falling back to straight-line distance.');
                }
            } catch (\Exception $e) {
                Log::warning('Distance Matrix request failed: ' . $e->getMessage() . ' — falling back to straight-line distance.');
                $data = null;
            }

            if (is_array($data) && ($data['status'] ?? '') !== 'OK') {
                Log::warning('Distance Matrix API status ' . ($data['status'] ?? 'UNKNOWN')
                    . (isset($data['error_message']) ? ': ' . $data['error_message'] : '')
                    . ' — falling back to straight-line distance.');
            }

            $elements = (is_array($data) && ($data['status'] ?? '') === 'OK')
                ? ($data['rows'][0]['elements'] ?? [])
                : [];

            $i = 0;
            foreach ($chunk as $key => $dest) {
                $element = isset($elements[$i]) ? $elements[$i] : null;
                $i++;

                $km = null;
                if (is_array($element)
                    && ($element['status'] ?? '') === 'OK'
                    && isset($element['distance']['value'])) {
                    $km = round(((int) $element['distance']['value']) / 1000, 2);
                } elseif (is_array($element) && ($element['status'] ?? '') !== 'OK') {
                    Log::warning('Distance Matrix element status ' . ($element['status'] ?? 'UNKNOWN')
                        . ' for destination ' . $dest[0] . ',' . $dest[1] . ' — using straight-line distance.');
                }

                $results[$key] = $km;
                // Cache hits for the full TTL, misses briefly.
                Cache::put($cacheKey($dest), $km === null ? false : $km, $km === null ? 600 : $ttl);
            }
        }

        return $results;
    }

    /**
     * Applies road distances to a collection of lab rows that carry lat/lng
     * (city coordinates) and a straight-line `distance` attribute, keeping the
     * straight-line value whenever the API has no answer for that lab.
     */
    private function apply_driving_distances($labs, $originLat, $originLng)
    {
        $destinations = [];
        foreach ($labs as $labRow) {
            if (is_numeric($labRow->lat) && is_numeric($labRow->lng)) {
                $destinations[$labRow->lat . ',' . $labRow->lng] = [(float) $labRow->lat, (float) $labRow->lng];
            }
        }
        if (empty($destinations)) {
            return $labs;
        }

        $drivingKm = $this->get_driving_distances($originLat, $originLng, $destinations);
        foreach ($labs as $labRow) {
            $labCoordKey = $labRow->lat . ',' . $labRow->lng;
            if (isset($drivingKm[$labCoordKey]) && $drivingKm[$labCoordKey] !== null) {
                $labRow->distance = $drivingKm[$labCoordKey];
            }
        }

        return $labs;
    }
}
