<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register – Rapid Route</title>
  <meta name="description" content="Create your Rapid Route account to start tracking shipments and managing your deliveries."/>
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
      <a href="/user/index" class="auth-logo">
        <div class="logo-icon">
          <svg width="32" height="32" viewBox="0 0 28 28" fill="none">
            <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="url(#regLogo)" stroke-width="2" fill="none"/>
            <defs><linearGradient id="regLogo" x1="4" y1="3" x2="24" y2="25"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs>
          </svg>
        </div>
        <span class="logo-text">Rapid<span>Route</span></span>
      </a>
      <div class="auth-panel-content">
        <h1>Join<br/><span class="gradient-text">500K+ Users</span></h1>
        <p>Start managing your shipments like a pro. Free forever, no credit card needed.</p>
        <div class="auth-features">
          <div class="auth-feat">
            <div class="auth-feat-icon" style="background:#6C63FF22">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <span>100% Free to use</span>
          </div>
          <div class="auth-feat">
            <div class="auth-feat-icon" style="background:#FF6B6B22">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5"/></svg>
            </div>
            <span>Instant SMS notifications</span>
          </div>
          <div class="auth-feat">
            <div class="auth-feat-icon" style="background:#F7971E22">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F7971E" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <span>Full shipment history</span>
          </div>
        </div>
      </div>
      <div class="auth-panel-deco">Trusted Worldwide</div>
    </div>

    <!-- Right Panel -->
    <div class="auth-panel-right">
      <div class="auth-form-card">
        <div class="auth-form-header">
          <h2>Create Account</h2>
          <p>Fill in your details to get started</p>
        </div>

        <div id="registerAlert" class="auth-alert" style="display:none;"></div>

        <form class="auth-form" id="registerForm" novalidate>
          <div class="form-row">
            <div class="form-group">
              <label for="regFirst" class="form-label">First Name</label>
              <div class="input-wrap">
                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <input type="text" id="regFirst" name="first_name" class="form-input" placeholder="John" required/>
              </div>
              <span class="field-error" id="regFirstError"></span>
            </div>
            <div class="form-group">
              <label for="regLast" class="form-label">Last Name</label>
              <div class="input-wrap">
                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <input type="text" id="regLast" name="last_name" class="form-input" placeholder="Doe" required/>
              </div>
              <span class="field-error" id="regLastError"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="regEmail" class="form-label">Email Address</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <input type="email" id="regEmail" name="email" class="form-input" placeholder="you@example.com" required autocomplete="email"/>
            </div>
            <span class="field-error" id="regEmailError"></span>
          </div>

          <div class="form-group">
            <label for="regPhone" class="form-label">Phone Number</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.84h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.4a16 16 0 0 0 6.29 5.52"/></svg>
              <input type="tel" id="regPhone" name="phone" class="form-input" placeholder="+91 98765 43210" required/>
            </div>
            <span class="field-error" id="regPhoneError"></span>
          </div>

          <div class="form-group">
            <label for="regPassword" class="form-label">Password</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="regPassword" name="password" class="form-input" placeholder="Min. 8 characters" required/>
              <button type="button" class="toggle-password" onclick="togglePassword('regPassword', this)" aria-label="Toggle password">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <div class="password-strength" id="passwordStrength">
              <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
              <span id="strengthLabel">Enter password</span>
            </div>
            <span class="field-error" id="regPasswordError"></span>
          </div>

          <div class="form-group">
            <label for="regConfirm" class="form-label">Confirm Password</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="regConfirm" name="password_confirmation" class="form-input" placeholder="Re-enter password" required/>
              <button type="button" class="toggle-password" onclick="togglePassword('regConfirm', this)" aria-label="Toggle password">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <span class="field-error" id="regConfirmError"></span>
          </div>

          <div class="form-check">
            <input type="checkbox" id="agreeTerms" name="terms"/>
            <label for="agreeTerms">I agree to the <a href="#" class="link-inline">Terms of Service</a> and <a href="#" class="link-inline">Privacy Policy</a></label>
          </div>

          <button type="submit" class="btn-auth" id="registerSubmit">
            <span>Create Account</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </button>
        </form>

        <div class="auth-divider"><span>Already have an account?</span></div>
        <a href="/user/login" class="btn-auth-outline">Sign In Instead</a>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
