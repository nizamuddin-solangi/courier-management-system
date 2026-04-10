<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile – Rapid Route</title>
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
    /* Make the profile layout fill viewport */
    .auth-panel-right { justify-content: stretch; align-items: stretch; }
    @media (max-width: 900px) { .auth-panel-right { padding: 2rem 1.5rem; } }
    /* Remove left panel spacing (profile is full width) */
    .auth-panel-right { background: transparent; }

    .profile-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 18px;
    }
    .profile-back {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 14px;
      border-radius: 14px;
      border: 1px solid var(--border-glass);
      background: rgba(255,255,255,0.04);
      color: var(--text-secondary);
      text-decoration: none;
      font-weight: 700;
      transition: var(--transition-fast);
    }
    .profile-back:hover { background: rgba(255,255,255,0.08); color: var(--text-primary); transform: translateY(-1px); }

    .profile-card {
      width: 100%;
      max-width: none;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border-glass);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-card);
      overflow: hidden;
      animation: fadeInUp 0.6s ease both;
    }

    .profile-hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      padding: 22px 24px;
      border-bottom: 1px solid var(--border-subtle);
      background: linear-gradient(135deg, rgba(108,99,255,0.16), rgba(255,107,107,0.06));
    }

    .profile-hero h2 { margin: 0; font-size: 1.4rem; font-weight: 900; letter-spacing: -0.5px; }
    .profile-hero p { margin: 6px 0 0; color: var(--text-secondary); font-family: var(--font-body); font-size: 0.92rem; }

    .profile-grid {
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 18px;
      padding: 22px;
    }
    @media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } }

    .avatar-panel {
      background: rgba(10,10,26,0.35);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 18px;
    }
    .avatar-ring {
      width: 110px;
      height: 110px;
      border-radius: 28px;
      margin: 6px auto 12px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      background: linear-gradient(135deg, rgba(108,99,255,0.35), rgba(67,233,123,0.20));
      border: 1px solid rgba(255,255,255,0.12);
      box-shadow: 0 18px 50px rgba(0,0,0,0.45);
      cursor: pointer;
      transition: var(--transition);
    }
    .avatar-ring:hover { transform: translateY(-2px); box-shadow: 0 24px 70px rgba(0,0,0,0.55); }
    .avatar-ring img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-initial {
      font-size: 44px;
      font-weight: 900;
      color: #0b0c10;
      text-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .avatar-overlay {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: rgba(0,0,0,0.55);
      opacity: 0;
      transition: var(--transition-fast);
      color: white;
      font-weight: 800;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      font-size: 11px;
    }
    .avatar-ring:hover .avatar-overlay { opacity: 1; }

    .mini-stat {
      display: grid;
      gap: 10px;
      margin-top: 14px;
    }
    .mini-stat .row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 14px;
      border: 1px solid rgba(255,255,255,0.10);
      background: rgba(255,255,255,0.03);
      color: var(--text-secondary);
      font-size: 0.85rem;
    }
    .mini-stat .row strong { color: var(--text-primary); font-weight: 800; }

    .form-panel {
      background: rgba(10,10,26,0.22);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 18px;
    }
    .section-title {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding-bottom: 12px;
      margin-bottom: 14px;
      border-bottom: 1px solid var(--border-subtle);
    }
    .section-title h3 { margin: 0; font-size: 1.05rem; font-weight: 900; letter-spacing: -0.3px; }
    .chip {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 10px;
      border-radius: 999px;
      background: rgba(67,233,123,0.10);
      border: 1px solid rgba(67,233,123,0.25);
      color: var(--green);
      font-size: 0.78rem;
      font-weight: 800;
    }

    /* Make file input look premium */
    input[type="file"].form-input { padding-left: 2.8rem; }
  </style>

  <div class="auth-wrapper">
    <div class="auth-panel-right" style="flex: 1;">
      <div style="width:100%;">
        <div class="profile-topbar">
          <a href="/user/index" class="profile-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
            Back
          </a>
          <button type="button" class="profile-back" onclick="window.history.back()" style="cursor:pointer;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 6v6l4 2"/></svg>
            Previous
          </button>
        </div>

        <div class="profile-card">
          <div class="profile-hero">
            <div>
              <h2>Profile Settings</h2>
              <p>Premium account controls to keep your identity and security up to date.</p>
            </div>
            <div class="chip">
              <span style="width:8px;height:8px;border-radius:50%;background:currentColor;display:inline-block;"></span>
              Active session
            </div>
          </div>

          <div class="profile-grid">
            <div class="avatar-panel">
              @php
                $img = $user->image ? asset('uploads/users/' . $user->image) : null;
                $initial = strtoupper(substr($user->name ?: 'U', 0, 1));
              @endphp

              <label class="avatar-ring" for="profileImageInput" id="avatarRing">
                @if($img)
                  <img src="{{ $img }}" alt="Profile" id="avatarImg"/>
                @else
                  <div class="avatar-initial" id="avatarInitial">{{ $initial }}</div>
                @endif
                <div class="avatar-overlay">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                  Change
                </div>
              </label>

              <div style="text-align:center; margin-top: 10px;">
                <div style="font-weight:900; font-size: 1.05rem; letter-spacing:-0.2px;">{{ $user->name }}</div>
                <div style="margin-top:4px; color: var(--text-muted); font-size: 0.85rem; font-family: var(--font-body);">{{ $user->email }}</div>
              </div>

              <div class="mini-stat">
                <div class="row"><span>Phone</span><strong>{{ $user->phone }}</strong></div>
                <div class="row"><span>Status</span><strong>Verified</strong></div>
              </div>
            </div>

            <div class="form-panel">
              @if(session('success'))
                <div class="auth-alert success" style="display:block; margin-bottom: 16px;">{{ session('success') }}</div>
              @endif

              @if ($errors->any())
                <div class="auth-alert error" style="display:block; margin-bottom: 16px;">
                  {{ $errors->first() }}
                </div>
              @endif

              <form class="auth-form" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="section-title">
                  <h3>Identity</h3>
                  <span style="color:var(--text-muted); font-size:0.85rem;">Update your public info</span>
                </div>

                <input type="file" id="profileImageInput" name="image" class="form-input" accept="image/png,image/jpeg,image/jpg,image/webp" style="display:none;"/>

                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrap">
                      <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                      <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <div class="input-wrap">
                      <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.84h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81"/></svg>
                      <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" required/>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Email</label>
                  <div class="input-wrap">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="email"/>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">Address</label>
                  <div class="input-wrap">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}" placeholder="House #, Street, Area, City"/>
                  </div>
                </div>

                <div class="auth-divider"><span>Security</span></div>

                <div class="section-title" style="margin-top: -6px;">
                  <h3>Password</h3>
                  <span style="color:var(--text-muted); font-size:0.85rem;">Leave blank to keep it</span>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="input-wrap">
                      <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      <input type="password" id="profPassword" name="password" class="form-input" placeholder="Leave blank to keep current"/>
                      <button type="button" class="toggle-password" onclick="togglePassword('profPassword', this)" aria-label="Toggle password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      </button>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                      <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      <input type="password" id="profConfirm" name="password_confirmation" class="form-input" placeholder="Repeat new password"/>
                      <button type="button" class="toggle-password" onclick="togglePassword('profConfirm', this)" aria-label="Toggle password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="form-row" style="margin-top: 6px;">
                  <button type="button" class="btn-auth-outline" onclick="window.location.href='/user/index'">Cancel</button>
                  <button type="submit" class="btn-auth">
                    <span>Save Changes</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </button>
                </div>

                <a href="/user/logout" class="btn-auth-outline" style="margin-top: -6px;">Sign Out</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/main.js') }}"></script>
  <script>
    (function () {
      const input = document.getElementById('profileImageInput');
      const ring = document.getElementById('avatarRing');
      if (!input || !ring) return;

      input.addEventListener('change', (e) => {
        const file = input.files && input.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);

        const existingImg = document.getElementById('avatarImg');
        const existingInitial = document.getElementById('avatarInitial');

        if (existingInitial) existingInitial.remove();
        if (existingImg) {
          existingImg.src = url;
        } else {
          const img = document.createElement('img');
          img.id = 'avatarImg';
          img.src = url;
          img.alt = 'Profile';
          ring.insertBefore(img, ring.firstChild);
        }
      });
    })();
  </script>
</body>
</html>

