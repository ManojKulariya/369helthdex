<div class="luxury-lab-card">
  <div class="luxury-lab-header">
    <div class="luxury-lab-info">
      <h4 class="luxury-lab-name">{{ Str::limit($df->name ?? '', 50) }}</h4>
      <div class="luxury-lab-distance">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
          <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
        </svg>
        {{ number_format($df->distance ?? 0, 2) }} KM
      </div>
    </div>
  </div>
  
  <div class="luxury-lab-address">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
      <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
    </svg>
    <span>{{ $df->address ?? 'Address not available' }}</span>
  </div>
  
  @php
    /* Prefer the lab's coordinates; fall back to its address. Never a
       hardcoded location — everything comes from this card's $df row. */
    $hdLabLat = $df->location['lat'] ?? null;
    $hdLabLng = $df->location['lng'] ?? null;
    $hdLabHasCoords = is_numeric($hdLabLat) && is_numeric($hdLabLng)
        && (float) $hdLabLat != 0.0 && (float) $hdLabLng != 0.0;
    $hdLabAddress = trim((string) ($df->address ?? ''));

    $hdLabMapUrl = null;
    if ($hdLabHasCoords) {
        $hdLabMapUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . (float) $hdLabLat . ',' . (float) $hdLabLng;
    } elseif ($hdLabAddress !== '') {
        $hdLabMapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($hdLabAddress);
    }
  @endphp
  @if($hdLabMapUrl)
  <a href="{{ $hdLabMapUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-md luxury-lab-cta" aria-label="Get directions to {{ $df->name ?? 'this lab' }} on Google Maps">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
      <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
    </svg>
    Get Directions
  </a>
  @else
  <button type="button" class="btn btn-primary btn-md luxury-lab-cta" disabled aria-disabled="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
      <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
    </svg>
    Location not available
  </button>
  @endif
</div>
