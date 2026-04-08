<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rapid Route – Track. Deliver. Trust.</title>
  <meta name="description" content="Rapid Route – The world's most premium courier tracking platform. Track your shipments in real-time with unparalleled ease." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="landing-body">

  <!-- Animated Background -->
  <div class="bg-canvas">
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-orb orb-3"></div>
    <div class="particle-field" id="particleField"></div>
  </div>

  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <div class="nav-container">
      <a href="index" class="nav-logo">
        <div class="logo-icon">
          <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
            <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="url(#logoGrad)" stroke-width="2" fill="none"/>
            <path d="M14 3V25M4 8L24 8M4 20L24 20" stroke="url(#logoGrad)" stroke-width="1.5" opacity="0.5"/>
            <defs>
              <linearGradient id="logoGrad" x1="4" y1="3" x2="24" y2="25">
                <stop offset="0%" stop-color="#6C63FF"/>
                <stop offset="100%" stop-color="#FF6B6B"/>
              </linearGradient>
            </defs>
          </svg>
        </div>
        <span class="logo-text">Rapid<span>Route</span></span>
      </a>
      <div class="nav-links">
        <a href="#features" class="nav-link">Features</a>
        <a href="#how-it-works" class="nav-link">How It Works</a>
        <a href="/user/track" class="nav-link">Track</a>
        <a href="/user/login" class="btn-nav-login">Sign In</a>
        <a href="/user/register" class="btn-nav-signup">Get Started</a>
      </div>
      <button class="hamburger" id="hamburger" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="#features">Features</a>
      <a href="#how-it-works">How It Works</a>
      <a href="track.html">Track</a>
      <a href="login.html">Sign In</a>
      <a href="register.html">Get Started</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-content">
      <div class="hero-badge">
        <span class="badge-dot"></span>
        Trusted by 500,000+ users worldwide
      </div>
      <h1 class="hero-title">
        Your Parcel,<br/>
        <span class="gradient-text">Always Found.</span>
      </h1>
      <p class="hero-subtitle">
        Real-time courier tracking with unmatched precision. Know exactly where your shipment is, every step of the journey.
      </p>

      <!-- Quick Track Bar -->
      <div class="quick-track-bar" id="quickTrackBar">
        <div class="track-input-wrap">
          <svg class="track-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <input type="text" id="heroTrackInput" placeholder="Enter consignment / tracking number..." class="track-input" />
        </div>
        <button class="btn-track" id="heroTrackBtn" onclick="trackFromHero()">
          <span>Track Now</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </div>

      <div class="hero-stats">
        <div class="stat-item">
          <span class="stat-number">2M+</span>
          <span class="stat-label">Packages Tracked</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
          <span class="stat-number">99.8%</span>
          <span class="stat-label">On-Time Delivery</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
          <span class="stat-number">150+</span>
          <span class="stat-label">Cities Covered</span>
        </div>
      </div>
    </div>

    <div class="hero-visual">
      <div class="phone-mockup">
        <div class="phone-screen">
          <div class="phone-header">
            <div class="status-bar">
              <span>9:41</span>
              <div class="status-icons">
                <svg width="16" height="12" viewBox="0 0 16 12"><rect x="0" y="3" width="3" height="9" rx="1" fill="currentColor" opacity="0.4"/><rect x="4.5" y="2" width="3" height="10" rx="1" fill="currentColor" opacity="0.6"/><rect x="9" y="0" width="3" height="12" rx="1" fill="currentColor"/><rect x="13.5" y="0" width="2" height="12" rx="1" fill="currentColor" stroke="currentColor" stroke-width="0.5" fill-opacity="0"/></svg>
              </div>
            </div>
            <h3 class="phone-title">Live Tracking</h3>
            <div class="tracking-number-display">AWB: SWF-2024-78945</div>
          </div>
          <div class="track-timeline-mock">
            <div class="tl-step tl-done">
              <div class="tl-dot done"></div>
              <div class="tl-info">
                <span class="tl-event">Order Picked Up</span>
                <span class="tl-time">Today, 09:00 AM</span>
              </div>
            </div>
            <div class="tl-step tl-done">
              <div class="tl-dot done"></div>
              <div class="tl-info">
                <span class="tl-event">In Transit – Mumbai Hub</span>
                <span class="tl-time">Today, 11:30 AM</span>
              </div>
            </div>
            <div class="tl-step tl-active">
              <div class="tl-dot active pulse-dot"></div>
              <div class="tl-info">
                <span class="tl-event">Out for Delivery</span>
                <span class="tl-time">Today, 2:15 PM</span>
              </div>
            </div>
            <div class="tl-step">
              <div class="tl-dot"></div>
              <div class="tl-info">
                <span class="tl-event">Delivered</span>
                <span class="tl-time">Expected by 6:00 PM</span>
              </div>
            </div>
          </div>
          <div class="phone-delivery-card">
            <div class="delivery-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
              On Track
            </div>
            <span>Est. Delivery: Today</span>
          </div>
        </div>
      </div>
      <div class="floating-card card-1">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>Package secured</span>
      </div>
      <div class="floating-card card-2">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <span>Live GPS</span>
      </div>
      <div class="floating-card card-3">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#43E97B" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.84h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.4a16 16 0 0 0 6.29 5.52"/></svg>
        <span>SMS Alerts</span>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section" id="features">
    <div class="section-container">
      <div class="section-header">
        <div class="section-badge">✦ Why Choose Rapid Route</div>
        <h2 class="section-title">Everything you need,<br/><span class="gradient-text">all in one place</span></h2>
      </div>
      <div class="features-grid">
        <div class="feature-card fc-large">
          <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #6C63FF22, #6C63FF11);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <h3>Real-Time Tracking</h3>
          <p>Watch your parcel move on a live map. Get minute-by-minute updates from pickup to doorstep delivery.</p>
          <div class="feature-tag">GPS Enabled</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #FF6B6B22, #FF6B6B11);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.84h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11"/></svg>
          </div>
          <h3>SMS Alerts</h3>
          <p>Instant notifications at every stage of your delivery.</p>
          <div class="feature-tag">Instant</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #43E97B22, #43E97B11);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#43E97B" stroke-width="1.8"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
          </div>
          <h3>Proof of Delivery</h3>
          <p>Digital confirmation with timestamp once delivered.</p>
          <div class="feature-tag">Verified</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #F7971E22, #F7971E11);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#F7971E" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
          </div>
          <h3>Print Report</h3>
          <p>Download and print your full shipment status report in one click.</p>
          <div class="feature-tag">PDF Ready</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #A855F722, #A855F711);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#A855F7" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3>Secure Platform</h3>
          <p>Your data is encrypted and secured at every layer.</p>
          <div class="feature-tag">SSL Secured</div>
        </div>
        <div class="feature-card fc-large">
          <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #38BDF822, #38BDF811);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#38BDF8" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <h3>Multi-User Access</h3>
          <p>Register as a customer and manage all your shipments from one dashboard. View history, track multiple parcels and print all statuses at once.</p>
          <div class="feature-tag">Smart Dashboard</div>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="how-section" id="how-it-works">
    <div class="section-container">
      <div class="section-header">
        <div class="section-badge">✦ Simple Process</div>
        <h2 class="section-title">Track in <span class="gradient-text">3 easy steps</span></h2>
      </div>
      <div class="steps-wrap">
        <div class="step-card" data-step="1">
          <div class="step-number">01</div>
          <div class="step-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="url(#sg1)" stroke-width="1.8"><defs><linearGradient id="sg1" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <h3>Create Account</h3>
          <p>Register in seconds with your name, phone, and email. No complicated forms.</p>
        </div>
        <div class="step-connector">
          <svg width="60" height="20" viewBox="0 0 60 20"><path d="M0 10h50M45 5l10 5-10 5" stroke="url(#arrowGrad)" stroke-width="2" fill="none"/><defs><linearGradient id="arrowGrad"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs></svg>
        </div>
        <div class="step-card" data-step="2">
          <div class="step-number">02</div>
          <div class="step-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="url(#sg2)" stroke-width="1.8"><defs><linearGradient id="sg2" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#43E97B"/></linearGradient></defs><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          </div>
          <h3>Enter Tracking ID</h3>
          <p>Input your consignment number from the shipment receipt or SMS.</p>
        </div>
        <div class="step-connector">
          <svg width="60" height="20" viewBox="0 0 60 20"><path d="M0 10h50M45 5l10 5-10 5" stroke="url(#arrowGrad2)" stroke-width="2" fill="none"/><defs><linearGradient id="arrowGrad2"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#43E97B"/></linearGradient></defs></svg>
        </div>
        <div class="step-card" data-step="3">
          <div class="step-number">03</div>
          <div class="step-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="url(#sg3)" stroke-width="1.8"><defs><linearGradient id="sg3" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#43E97B"/><stop offset="1" stop-color="#38BDF8"/></linearGradient></defs><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <h3>Live Status</h3>
          <p>Get instant real-time updates, view full timeline, and print your receipt.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="cta-container">
      <div class="cta-glow"></div>
      <h2 class="cta-title">Ready to track your next shipment?</h2>
      <p class="cta-subtitle">Join over 500,000 users who trust Rapid Route every day.</p>
      <div class="cta-buttons">
        <a href="register.html" class="btn-primary">Create Free Account</a>
        <a href="track.html" class="btn-ghost">Track a Package</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="nav-logo" style="margin-bottom:1rem">
          <div class="logo-icon">
            <svg width="24" height="24" viewBox="0 0 28 28" fill="none">
              <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="url(#fLogo)" stroke-width="2" fill="none"/>
              <defs><linearGradient id="fLogo" x1="4" y1="3" x2="24" y2="25"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs>
            </svg>
          </div>
          <span class="logo-text">Rapid<span>Route</span></span>
        </div>
        <p>Premium courier tracking for everyone. Fast, reliable, transparent.</p>
      </div>
      <div class="footer-links">
        <div class="footer-col">
          <h4>Platform</h4>
          <a href="track.html">Track Shipment</a>
          <a href="login.html">Sign In</a>
          <a href="register.html">Register</a>
        </div>
        <div class="footer-col">
          <h4>Support</h4>
          <a href="#">FAQ</a>
          <a href="#">Contact Us</a>
          <a href="#">Privacy Policy</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2024 Rapid Route. All rights reserved.</span>
    </div>
  </footer>

  <script src="js/main.js"></script>
  <script src="js/landing.js"></script>
</body>
</html>
