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
  <link rel="stylesheet" href="{{ asset('css/portals.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
      <a href="/user/index" class="nav-logo">
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
        
        <x-portal-nav />

        @if(session('user_logged_in'))
          @php
            $userImage = session('user_image');
            $userName = session('user_name') ?: 'User';
          @endphp
          <div class="nav-user" style="display:flex;align-items:center;gap:10px;">
            <a href="/user/profile" style="display:flex;align-items:center;gap:10px;padding:6px 10px;border:1px solid var(--border-glass);border-radius:999px;background:rgba(255,255,255,0.04);text-decoration:none;">
              @if($userImage)
                <img src="{{ asset('uploads/users/' . $userImage) }}" alt="Profile" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:1px solid rgba(255,255,255,0.12);" />
              @else
                <div style="width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(108,99,255,0.18);border:1px solid rgba(108,99,255,0.35);font-weight:800;color:var(--purple-light);">
                  {{ strtoupper(substr($userName, 0, 1)) }}
                </div>
              @endif
              <span style="font-weight:700;color:var(--text-primary);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $userName }}
              </span>
            </a>
            <a href="/user/notifications" class="btn-nav-login" style="background:rgba(108,99,255,0.08);border-color:rgba(108,99,255,0.25);color:var(--purple-light);">Notifications</a>
            <a href="/user/logout" class="btn-nav-login" style="background:rgba(255,255,255,0.04);border-color:var(--border-glass);color:var(--text-secondary);">Sign Out</a>
          </div>
        @else
          <a href="/user/login" class="btn-nav-login">Sign In</a>
          <a href="/user/register" class="btn-nav-signup">Get Started</a>
        @endif
      </div>
      <button class="hamburger" id="hamburger" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="#features">Features</a>
      <a href="#how-it-works">How It Works</a>
      <a href="/user/track">Track</a>
      
      <div style="margin: 10px 0; padding: 15px; border: 1px solid var(--border-glass); border-radius: 16px; background: rgba(255,255,255,0.03);">
        <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px;">System Portals</div>
        <a href="/user/profile" style="display: flex !important; align-items: center; justify-content: space-between; padding: 8px 0 !important; border:none !important; background:none !important;">
          <span style="font-size: 0.9rem;">Customer Portal</span>
          <span class="status-dot {{ session('user_logged_in') ? 'online' : '' }}" style="position:static; border:none; width:10px; height:10px;"></span>
        </a>
        <a href="/agent/dashboard" style="display: flex !important; align-items: center; justify-content: space-between; padding: 8px 0 !important; border:none !important; background:none !important;">
          <span style="font-size: 0.9rem;">Agent Node</span>
          <span class="status-dot {{ session('agent_logged_in') ? 'online' : '' }}" style="position:static; border:none; width:10px; height:10px;"></span>
        </a>
        <a href="/admin/dashboard" style="display: flex !important; align-items: center; justify-content: space-between; padding: 8px 0 !important; border:none !important; background:none !important;">
          <span style="font-size: 0.9rem;">Admin Intelligence</span>
          <span class="status-dot {{ session('admin_logged_in') ? 'online' : '' }}" style="position:static; border:none; width:10px; height:10px;"></span>
        </a>
      </div>

      @if(session('user_logged_in'))
        <a href="/user/logout">Sign Out</a>
      @else
        <a href="/user/login">Sign In</a>
        <a href="/user/register">Get Started</a>
      @endif
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
          <input type="text" id="heroTrackInput" placeholder="Enter consignment / tracking number..." class="track-input" onkeydown="if(event.key==='Enter') trackFromHero()" />
        </div>
        <button class="btn-track" id="heroTrackBtn" onclick="trackFromHero()">
          <span>Track Now</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </div>

      <!-- Login Required Modal (Copy from track page) -->
      <div id="loginRequiredModal" style="display:none; position:fixed; inset:0; z-index:9999;">
        <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
        <div style="position:relative; height:100%; display:flex; align-items:center; justify-content:center; padding:18px;">
          <div style="width:min(520px, 100%); background:#101323; border:1px solid rgba(255,255,255,0.10); border-radius:24px; padding:22px; box-shadow: 0 20px 80px rgba(0,0,0,0.55); backdrop-filter:blur(30px);">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
              <div style="display:flex; gap:12px; align-items:flex-start;">
                <div style="width:44px; height:44px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:rgba(108,99,255,0.18); border:1px solid rgba(108,99,255,0.35);">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="url(#lgReq)" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <defs><linearGradient id="lgReq" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs>
                  </svg>
                </div>
                <div>
                  <h3 style="margin:0; font-size:1.2rem; font-weight:800; color:var(--text-primary);">Join Rapid Route</h3>
                  <p style="margin:6px 0 0; color:var(--text-secondary); font-family:var(--font-body); line-height:1.5;">
                    Create an account to save your tracking history and get instant SMS alerts for your shipments.
                  </p>
                </div>
              </div>
              <button type="button" onclick="closeLoginRequired()" aria-label="Close"
                style="background:transparent; border:0; color:var(--text-secondary); cursor:pointer; padding:6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
              </button>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
              <a href="/user/login" class="btn-primary" style="text-decoration:none; padding:0.8rem 1.4rem; font-size:0.9rem;">
                Sign In
              </a>
              <a href="/user/register" class="btn-ghost" style="text-decoration:none; padding:0.8rem 1.4rem; font-size:0.9rem;">
                Register Free
              </a>
            </div>
          </div>
        </div>
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

  <!-- My Shipments Section (Visible after login) -->
  @if(session('user_logged_in') && isset($shipments) && $shipments->isNotEmpty())
  <section class="user-shipments-section" id="my-shipments" style="padding: 40px 2rem 100px; position: relative; z-index: 10;">
    <div class="section-container">
      <div class="section-header" style="text-align: left; margin-bottom: 2.5rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div class="animate-in">
          <div class="section-badge">✦ Welcome Back</div>
          <h2 class="section-title">Your <span class="gradient-text">Recent Shipments</span></h2>
          <p style="color:var(--text-secondary); margin-top: 10px; font-family: var(--font-body); max-width: 500px;">We've automatically synced shipments associated with your phone number.</p>
        </div>
        <a href="/user/track" class="btn-ghost animate-in" style="text-decoration: none; padding: 12px 24px; border-radius: 12px;">View All Tracking</a>
      </div>

      <div class="shipments-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 1.5rem;">
        @foreach($shipments as $ship)
        <div class="feature-card animate-in" style="padding: 2rem; display: flex; flex-direction: column; height: 100%; position: relative; overflow: hidden; animation-delay: {{ $loop->index * 0.1 }}s">
          <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(108,99,255,0.05) 0%, transparent 70%); pointer-events: none;"></div>
          
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div style="display: flex; flex-direction: column;">
              <span style="font-size: 0.7rem; color: var(--purple-light); font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 4px; opacity: 0.8;">Awb / Tracking Id</span>
              <h4 style="font-size: 1.3rem; font-weight: 800; color: #fff; letter-spacing: -0.5px;">{{ $ship->tracking_number }}</h4>
            </div>
            @php
              $status = strtolower($ship->status);
              $badgeColor = '#F7971E'; // Pending
              if($status == 'in_transit') $badgeColor = '#6C63FF';
              if($status == 'delivered') $badgeColor = '#43E97B';
              if($status == 'cancelled') $badgeColor = '#FF6B6B';
            @endphp
            <div style="padding: 6px 14px; border-radius: 50px; background: {{ $badgeColor }}12; border: 1px solid {{ $badgeColor }}30; color: {{ $badgeColor }}; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 6px;">
              <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $badgeColor }}; box-shadow: 0 0 8px {{ $badgeColor }};"></span>
              {{ str_replace('_', ' ', $status) }}
            </div>
          </div>

          <div style="margin-bottom: 2rem; position: relative;">
            <div style="position: absolute; left: 15px; top: 25px; bottom: 25px; width: 2px; background: linear-gradient(to bottom, var(--purple) 0%, rgba(255,255,255,0.05) 100%); opacity: 0.3;"></div>
            
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px; position: relative; z-index: 1;">
              <div style="width: 32px; height: 32px; border-radius: 10px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                <i class="bi bi-geo-alt" style="font-size: 14px;"></i>
              </div>
              <div style="display: flex; flex-direction: column;">
                <span style="font-size: 0.65rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Origin Hub</span>
                <span style="font-size: 1rem; font-weight: 700; color: var(--text-primary);">{{ $ship->from_city }}</span>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 15px; position: relative; z-index: 1;">
              <div style="width: 32px; height: 32px; border-radius: 10px; background: rgba(108,99,255,0.1); border: 1px solid rgba(108,99,255,0.25); display: flex; align-items: center; justify-content: center; color: var(--purple-light);">
                <i class="bi bi-geo-alt-fill" style="font-size: 14px;"></i>
              </div>
              <div style="display: flex; flex-direction: column;">
                <span style="font-size: 0.65rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Destination</span>
                <span style="font-size: 1rem; font-weight: 700; color: var(--text-primary);">{{ $ship->to_city }}</span>
              </div>
            </div>
          </div>

          <div style="margin-top: auto; display: flex; gap: 10px; position: relative; z-index: 5;">
            <a href="/user/track?id={{ $ship->tracking_number }}" class="btn-track" style="flex: 1; justify-content: center; padding: 12px; font-size: 0.9rem; text-decoration: none; border-radius: 14px;">
              <span>Track Now</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

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

  <!-- Our Work / Success Showcase -->
  <section class="work-section" id="our-work">
    <div class="section-container">
      <div class="section-header">
        <div class="section-badge">✦ Our Proven Track Record</div>
        <h2 class="section-title">Showcasing our <br/><span class="gradient-text">global success stories</span></h2>
      </div>
      
      <div class="work-grid">
        <div class="work-card">
          <div class="work-image">
            <div class="work-overlay"></div>
            <div class="work-tag">Express Delivery</div>
            <div class="work-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
          </div>
          <div class="work-details">
            <h3>99.9% Route Optimization</h3>
            <p>We implemented AI-driven pathfinding for our European fleet, reducing delivery times by 40%.</p>
            <div class="work-stats">
              <div class="ws-item"><span>12M+</span><label>Kms Optimized</label></div>
              <div class="ws-item"><span>2024</span><label>Year</label></div>
            </div>
          </div>
        </div>
        
        <div class="work-card">
          <div class="work-image" style="background: linear-gradient(45deg, #FF6B6B22, #6C63FF11);">
            <div class="work-overlay"></div>
            <div class="work-tag">Technological Edge</div>
            <div class="work-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
          </div>
          <div class="work-details">
            <h3>Zero-Data Breach Security</h3>
            <p>Our platform handles millions of shipments with bank-grade encryption and secure private cloud storage.</p>
            <div class="work-stats">
              <div class="ws-item"><span>100%</span><label>Uptime</label></div>
              <div class="ws-item"><span>Cloud</span><label>Native</label></div>
            </div>
          </div>
        </div>
        
        <div class="work-card">
          <div class="work-image" style="background: linear-gradient(45deg, #43E97B22, #38BDF811);">
            <div class="work-overlay"></div>
            <div class="work-tag">Global Presence</div>
            <div class="work-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            </div>
          </div>
          <div class="work-details">
            <h3>Cross-Border Excellence</h3>
            <p>Connecting 150+ cities with a unified tracking network that never sleeps, ensuring trust every mile.</p>
            <div class="work-stats">
              <div class="ws-item"><span>150+</span><label>Cities</label></div>
              <div class="ws-item"><span>24/7</span><label>Support</label></div>
            </div>
          </div>
        </div>
      </div>

      <div class="achievement-banner">
        <div class="ach-glow"></div>
        <div class="ach-item">
          <span class="ach-number" data-target="500000">0</span><span class="ach-plus">+</span>
          <label>Satisfied Users</label>
        </div>
        <div class="ach-divider"></div>
        <div class="ach-item">
          <span class="ach-number" data-target="1000000">0</span><span class="ach-plus">+</span>
          <label>Packages Delivered</label>
        </div>
        <div class="ach-divider"></div>
        <div class="ach-item">
          <span class="ach-number" data-target="98">0</span><span class="ach-plus">%</span>
          <label>Positive Feedback</label>
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
        <a href="/user/register" class="btn-primary">Create Free Account</a>
        <a href="/user/track" class="btn-ghost">Track a Package</a>
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
          <a href="/user/track">Track Shipment</a>
          <a href="/user/login">Sign In</a>
          <a href="/user/register">Register</a>
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

  <script>
      const IS_LOGGED_IN = @json((bool) session('user_logged_in'));
      window.closeLoginRequired = function() {
          const m = document.getElementById('loginRequiredModal');
          if(m) m.style.display = 'none';
      };
      window.showLoginRequired = function() {
          const m = document.getElementById('loginRequiredModal');
          if(m) m.style.display = '';
      };
  </script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
