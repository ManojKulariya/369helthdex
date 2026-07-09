@php
  /* Pricing — display-only. Handles either column order (price/mrp) coming
     from the backend: the lower value is the selling price, the higher one
     is the original price. Nothing is hardcoded. */
  $hdPrice = (float) ($pl->price ?? 0);
  $hdMrp = (float) ($pl->mrp ?? 0);
  $hdCurrent = $hdMrp > 0 ? $hdMrp : $hdPrice;
  $hdOriginal = 0;
  $hdDiscount = 0;
  if ($hdPrice > 0 && $hdMrp > 0 && round($hdPrice) != round($hdMrp)) {
      $hdCurrent = min($hdPrice, $hdMrp);
      $hdOriginal = max($hdPrice, $hdMrp);
      $hdDiscount = round(100 * ($hdOriginal - $hdCurrent) / $hdOriginal);
  }

  /* Included tests — normalize whatever the backend provides:
     an array of ['name' => ...] rows, an array of strings, or a
     comma-separated string of names. */
  $hdParams = [];
  if (isset($pl->paramater_data)) {
      if (is_array($pl->paramater_data)) {
          foreach ($pl->paramater_data as $hdRow) {
              $hdName = is_array($hdRow) ? ($hdRow['name'] ?? '') : (string) $hdRow;
              if (trim($hdName) !== '') { $hdParams[] = trim($hdName); }
          }
      } elseif (is_string($pl->paramater_data) && trim($pl->paramater_data) !== '') {
          $hdParams = array_values(array_filter(array_map('trim', explode(',', $pl->paramater_data))));
      }
  }
@endphp
<div class="premium-package-card">
  <!-- Discount Badge -->
  @if($hdDiscount > 0)
    <div class="premium-package-discount">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="M12.53 3.47a.75.75 0 01.073.878l-.073.092-6.25 6.25a.75.75 0 01-.977.073l-.084-.073-3-3a.75.75 0 01.977-1.133l.084.073 2.47 2.47 5.69-5.69a.75.75 0 01.99-.073z" clip-rule="evenodd" />
      </svg>
      {{ $hdDiscount }}% OFF
    </div>
  @endif

  <!-- Card Header -->
  <div class="premium-package-header">
    <div class="premium-package-icon-wrapper">
      <i data-lucide="heart-pulse" class="premium-package-icon"></i>
    </div>

    <h4 class="premium-package-name">{{ $pl->name ?? '' }}</h4>

    <div class="premium-package-params">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
      </svg>
      @if(isset($pl) && isset($pl->no_of_parameter) && $pl->no_of_parameter > 0)
        {{ $pl->no_of_parameter }} Tests Included
      @else
        Comprehensive Package
      @endif
    </div>
  </div>

  <!-- Card Body -->
  <div class="premium-package-body">
    @if(count($hdParams) > 0)
    <div class="premium-package-features">
      <div class="premium-package-features-title">Package Includes</div>
      <ul class="premium-features-list">
        @foreach(array_slice($hdParams, 0, 4) as $param)
          <li class="premium-feature-item">
            <span class="premium-feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
              </svg>
            </span>
            {{ $param }}
          </li>
        @endforeach
        @if(count($hdParams) > 4)
          <li class="premium-feature-item premium-feature-more">
            <span class="premium-feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12 4.5a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V5.25A.75.75 0 0112 4.5z" clip-rule="evenodd" />
              </svg>
            </span>
            +{{ count($hdParams) - 4 }} more tests
          </li>
        @endif
      </ul>
    </div>
    @endif
  </div>

  <!-- Price Section -->
  <div class="premium-package-pricing">
    <div class="premium-price-row">
      <div class="premium-price-info">
        <span class="premium-price-label">Best Price</span>
        <div class="premium-price-values">
          @if($hdOriginal > 0)
            <span class="premium-price-original">₹{{ number_format($hdOriginal, 0) }}</span>
          @endif
          <span class="premium-price-current"><span>₹</span>{{ number_format($hdCurrent, 0) }}</span>
        </div>
      </div>
      @if($hdOriginal > 0)
        <div class="premium-savings-badge">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-4.28 9.22a.75.75 0 000 1.06l3 3a.75.75 0 101.06-1.06l-2.47-2.47 2.47-2.47a.75.75 0 00-1.06-1.06l-3 3z" clip-rule="evenodd" />
          </svg>
          Save ₹{{ number_format($hdOriginal - $hdCurrent, 0) }}
        </div>
      @endif
    </div>

    <!-- Action Buttons -->
    <div class="premium-package-actions">
      <a href="{{ isset($pl) ? route('package', ['city' => $cityName ?? 'rajkot', 'id' => $pl->slug ?? '']) : '#' }}" class="premium-btn premium-btn-secondary">
        View Details
      </a>
      <a href="{{ isset($pl) ? route('checkouts', ['id' => $pl->id ?? '', 'type' => 1, 'parameter' => $pl->no_of_parameter ?? 0]) : '#' }}" class="premium-btn premium-btn-primary">
        Book Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
        </svg>
      </a>
    </div>
  </div>
</div>
