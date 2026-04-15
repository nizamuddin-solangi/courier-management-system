<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register – Rapid Route</title>
  <meta name="description" content="Create your Rapid Route account to start tracking shipments and managing your deliveries."/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
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
  <style>
    .error-msg {
      color: #ff6b6b;
      font-size: 11px;
      font-weight: 700;
      margin-top: 5px;
      margin-left: 5px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    input:invalid:not(:placeholder-shown) {
      border-color: #ff6b6b !important;
    }

    .form-notice {
      background: rgba(108,99,255,0.05);
      border-left: 4px solid #6c63ff;
      padding: 1rem;
      border-radius: 0 1rem 1rem 0;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 12px;
    }
  </style>

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

        <div class="form-notice" style="margin-top: 1rem; margin-bottom: 1rem;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          <p style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Notice: Please complete all required fields. Real-time validation is active.</p>
        </div>

        <form class="auth-form" id="registerForm" novalidate>
          <div class="form-row">
            <div class="form-group">
              <label for="regFirst" class="form-label">First Name</label>
              <div class="input-wrap">
                <input type="text" id="regFirst" name="first_name" class="form-input" placeholder="John" required
                       pattern="[a-zA-Z\s]+" title="Real Pattern: Only letters and spaces allowed"/>
              </div>
              @error('first_name') <div class="error-msg">{{ $message }}</div> @enderror
              <span class="field-error" id="regFirstError"></span>
            </div>
            <div class="form-group">
              <label for="regLast" class="form-label">Last Name</label>
              <div class="input-wrap">
                <input type="text" id="regLast" name="last_name" class="form-input" placeholder="Doe" required
                       pattern="[a-zA-Z\s]+" title="Real Pattern: Only letters and spaces allowed"/>
              </div>
              @error('last_name') <div class="error-msg">{{ $message }}</div> @enderror
              <span class="field-error" id="regLastError"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="regEmail" class="form-label">Email Address</label>
            <div class="input-wrap">
              <input type="email" id="regEmail" name="email" class="form-input" placeholder="you@example.com" required autocomplete="email"/>
            </div>
            @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            <span class="field-error" id="regEmailError"></span>
          </div>

          <div class="form-group">
            <label for="regPhone" class="form-label">Phone Number</label>
            <div class="input-wrap">
              <input type="tel" id="regPhone" name="phone" class="form-input" placeholder="+92 XXX XXXXXXX" required
                     pattern="[0-9+]+" title="Real Pattern: Only digits and + allowed"/>
            </div>
            @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
            <span class="field-error" id="regPhoneError"></span>
          </div>

          <div class="form-group">
            <label for="regAddress" class="form-label">Address</label>
            <div class="input-wrap">
              <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <input type="text" id="regAddress" name="address" class="form-input" placeholder="House #, Street, Area, City" required/>
            </div>
            <div class="error-msg"></div>
            <span class="field-error" id="regAddressError"></span>
          </div>

          <div class="form-group">
            <label for="regImage" class="form-label">Profile Image (optional)</label>
            <div class="input-wrap">
              <input type="file" id="regImage" name="image" class="form-input" accept="image/png,image/jpeg,image/jpg,image/webp"/>
            </div>
            <div class="error-msg"></div>
            @error('image') <div class="error-msg">{{ $message }}</div> @enderror
            <span class="field-error" id="regImageError"></span>
          </div>

          <div class="form-group">
            <label for="regPassword" class="form-label">Password</label>
            <div class="input-wrap">
              <input type="password" id="regPassword" name="password" class="form-input" placeholder="Min. 6 characters" required minlength="6"/>
              <button type="button" class="toggle-password" onclick="togglePassword('regPassword', this)" aria-label="Toggle password">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password') <div class="error-msg">{{ $message }}</div> @enderror
            <div class="password-strength" id="passwordStrength">
              <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
              <span id="strengthLabel">Enter password</span>
            </div>
            <div class="error-msg"></div>
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
            <div class="error-msg"></div>
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
  <script>
    // Live Validation for User Registration
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('input', () => validateField(input));
            input.addEventListener('blur', () => validateField(input));
        });

        function validateField(input) {
            let container = input.closest('.form-group');
            let errorMsg = container.querySelector('.error-msg');
            
            if (input.required && !input.value.trim()) {
                showError(input, errorMsg, 'This field is required');
            } else if (input.pattern && !new RegExp('^' + input.pattern + '$').test(input.value)) {
                showError(input, errorMsg, input.title || 'Please match the required format');
            } else if (!input.checkValidity()) {
                showError(input, errorMsg, input.validationMessage);
            } else {
                clearError(input, errorMsg);
            }
        }

        function showError(input, errorMsg, message) {
            input.style.borderColor = '#ff6b6b';
            if (errorMsg) {
                errorMsg.textContent = message;
                errorMsg.style.display = 'block';
            }
        }

        function clearError(input, errorMsg) {
            input.style.borderColor = '';
            if (errorMsg) errorMsg.style.display = 'none';
        }
    });
  </script>
</body>
</html>
