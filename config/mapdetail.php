<?php

return [

          "key"=>env('MAP_KEY'),
          "lat"=>env('MAP_LAT'),
          "long"=>env('MAP_LONG'),
          "web_color"=>env('WEB_COLOR'),

          // Road-distance (Google Distance Matrix) settings for lab distances.
          // Successful results are cached this many hours; failures are cached
          // for 10 minutes so a broken key can't hammer the API.
          "distance_cache_hours"=>env('MAP_DISTANCE_CACHE_HOURS', 24),
    ];