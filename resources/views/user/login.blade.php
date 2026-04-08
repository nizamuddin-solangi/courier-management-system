<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login – Rapid Route</title>
  <meta name="description" content="Sign in to your Rapid Route account to track and manage your shipments."/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">
  <div class="bg-canvas">
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-orb orb-3"></div>
  </div>

  <div class="auth-wrapper">
    <!-- Left Panel -->
    <div class="auth-panel-left">
      <a href="index.html" class="auth-logo">
        <div class="logo-icon">
          <svg width="32" height="32" viewBox="0 0 28 28" fill="none">
            <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="url(#authLogo)" stroke-width="2" fill="none"/>
            <path d="M14 3V25M4 8L24 8M4 20L24 20" stroke="url(#authLogo2)" stroke-width="1.5" opacity="0.5"/>
            <defs>
              <linearGradient id="authLogo" x1="4" y1="3" x2="24" y2="25"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient>
              <linearGradient id="authLogo2" x1="4" y1="3" x2="24" y2="25"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient>
            </defs>
          </svg>
        </div>
        <span class="logo-text">Rapid<span>Route</span></span>
      </a>
      <div class="auth-panel-content">
        <h1>Welcome back to<br/><span class="gradient-text">Rapid Route</span></h1>
        <p>Track your parcels in real-time. Get instant updates. Manage everything from one dashboard.</p>
        <div class="auth-features">
          <div class="auth-feat">
            <div class="auth-feat-icon" style="background:#6C63FF22">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <span>Live GPS tracking</span>
          </div>
          <div class="auth-feat">
            <div class="auth-feat-icon" style="background:#43E97B22">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#43E97B" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
            </div>
            <span>Instant delivery confirmation</span>
          </div>
          <div class="auth-feat">
            <div class="auth-feat-icon" style="background:#38BDF822">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#38BDF8" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <span>Printable shipment reports</span>
          </div>
        </div>
      </div>
      <div class="auth-panel-deco">500K+ Active Users</div>
    </div>

    <!-- Right Panel: Form -->
    <div class="auth-panel-right">
      <div class="auth-form-card">
        <div class="auth-form-header">
          <h2>Sign In</h2>
          <p>Enter your credentials to continue</p>
        </div>

        <div id="loginAlert" class="auth-alert" style="display:none;"></div>

        <form class="auth-form" id="loginForm" novalidate>
          <div class="form-group">
            <label for="loginEmail" class="form-label">Email Address</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <input type="email" id="loginEmail" name="email" class="form-input" placeholder="you@example.com" required autocomplete="email"/>
            </div>
            <span class="field-error" id="loginEmailError"></span>
          </div>

          <div class="form-group">
            <label for="loginPassword" class="form-label">Password</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="loginPassword" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password"/>
              <button type="button" class="toggle-password" onclick="togglePassword('loginPassword', this)" aria-label="Toggle password">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <span class="field-error" id="loginPasswordError"></span>
          </div>

          <button type="submit" class="btn-auth" id="loginSubmit">
            <span>Sign In</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </button>
        </form>
        <a href="/user/register" class="btn-auth-outline">Create Account</a>
        <a href="/user/track" class="auth-guest-link">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          Track without signing in
        </a>
      </div>
    </div>
  </div>

  <script src="js/main.js"></script>
  <script src="js/auth.js"></script>
</body>
</html>
