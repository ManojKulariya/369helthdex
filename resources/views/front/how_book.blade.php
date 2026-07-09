<!-- Premium Booking Process Section -->
<section class="booking-process-section reveal">
  <div class="container">
    <!-- Section Header -->
    <div class="booking-section-header">
      <div class="booking-section-title-wrapper">
        <div class="booking-section-badge">
          <span class="booking-section-badge-icon">
            <i data-lucide="check"></i>
          </span>
          <span class="booking-section-badge-text">Simple Process</span>
        </div>
        <h2 class="booking-section-title">How To Book Your Test</h2>
        <p class="booking-section-description">Get your health checkup done in 5 simple steps with free home collection and NABL certified labs</p>
      </div>
    </div>
    
    <!-- Process Cards Grid -->
    <div class="process-cards-wrapper">
      <!-- Animated Connectors (Desktop Only) -->
      <div class="process-connector">
        <div class="process-connector-line"></div>
        <div class="process-connector-arrow"><i data-lucide="arrow-right"></i></div>
        <div class="process-connector-arrow"><i data-lucide="arrow-right"></i></div>
        <div class="process-connector-arrow"><i data-lucide="arrow-right"></i></div>
        <div class="process-connector-arrow"><i data-lucide="arrow-right"></i></div>
      </div>
      
      <div class="process-cards-grid">
        <!-- Step 1: Book Online -->
        <div class="process-card">
          <div class="process-step-number">1</div>
          <div class="process-icon-wrapper">
            <i data-lucide="calendar-check" class="process-icon"></i>
          </div>
          <h4 class="process-card-title">Book Online</h4>
          <p class="process-card-description">Choose your test or package on our website or app</p>
        </div>
        
        <!-- Step 2: Get Guidance -->
        <div class="process-card">
          <div class="process-step-number">2</div>
          <div class="process-icon-wrapper">
            <i data-lucide="stethoscope" class="process-icon"></i>
          </div>
          <h4 class="process-card-title">Get Guidance</h4>
          <p class="process-card-description">Our health advisors will assist you throughout</p>
        </div>
        
        <!-- Step 3: Sample Collection -->
        <div class="process-card">
          <div class="process-step-number">3</div>
          <div class="process-icon-wrapper">
            <i data-lucide="flask-conical" class="process-icon"></i>
          </div>
          <h4 class="process-card-title">Sample Collection</h4>
          <p class="process-card-description">Expert phlebotomists visit your home for free</p>
        </div>
        
        <!-- Step 4: Lab Processing -->
        <div class="process-card">
          <div class="process-step-number">4</div>
          <div class="process-icon-wrapper">
            <i data-lucide="microscope" class="process-icon"></i>
          </div>
          <h4 class="process-card-title">Lab Processing</h4>
          <p class="process-card-description">Samples analyzed in NABL certified labs</p>
        </div>
        
        <!-- Step 5: Get Reports -->
        <div class="process-card">
          <div class="process-step-number">5</div>
          <div class="process-icon-wrapper">
            <i data-lucide="file-text" class="process-icon"></i>
          </div>
          <h4 class="process-card-title">Get Reports</h4>
          <p class="process-card-description">Smart digital reports with free doctor consultation</p>
        </div>
      </div>
    </div>
    
    <!-- CTA Section -->
    <div class="booking-cta-section">
      <a href="{{route('popular-packages',['city'=>$cityName ?? 'rajkot'])}}" class="booking-cta-button">
        Book Your Test Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
        </svg>
      </a>
      
      <!-- Trust Badges -->
      <div class="booking-trust-badges">
        <div class="trust-badge-item">
          <span class="trust-badge-icon">
            <i data-lucide="check"></i>
          </span>
          NABL Certified Labs
        </div>
        <div class="trust-badge-item">
          <span class="trust-badge-icon">
            <i data-lucide="check"></i>
          </span>
          Free Home Collection
        </div>
        <div class="trust-badge-item">
          <span class="trust-badge-icon">
            <i data-lucide="check"></i>
          </span>
          Secure Reports
        </div>
      </div>
    </div>
  </div>
</section>
