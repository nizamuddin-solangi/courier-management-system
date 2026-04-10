<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications – Rapid Route</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/track.css') }}">
</head>
<body class="track-body">
  <div class="bg-canvas">
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
  </div>

  <nav class="navbar" id="navbar">
    <div class="nav-container">
      <a href="/user/index" class="nav-logo">
        <div class="logo-icon">
          <svg width="24" height="24" viewBox="0 0 28 28" fill="none">
            <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="url(#nLogo)" stroke-width="2" fill="none"/>
            <defs><linearGradient id="nLogo" x1="4" y1="3" x2="24" y2="25"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs>
          </svg>
        </div>
        <span class="logo-text">Rapid<span>Route</span></span>
      </a>

      <div class="nav-links">
        <a href="/user/track" class="nav-link">Track</a>
        <a href="/user/profile" class="nav-link">Profile</a>
        <a href="/user/notifications" class="nav-link" style="position:relative;">
          Notifications
          @if(($unreadCount ?? 0) > 0)
            <span style="position:absolute;top:-6px;right:-10px;min-width:18px;height:18px;padding:0 6px;border-radius:999px;background:rgba(255,107,107,0.16);border:1px solid rgba(255,107,107,0.35);color:#FF8A8A;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">
              {{ $unreadCount }}
            </span>
          @endif
        </a>
        <a href="/user/logout" class="btn-nav-login">Sign Out</a>
      </div>
    </div>
  </nav>

  <div class="track-page-header" style="padding-top:110px;">
    <h1>Your <span class="gradient-text">Notifications</span></h1>
    <p>Updates sent by Admin/Agent about your shipments.</p>
  </div>

  <div class="track-result-section" style="display:block;">
    <div class="result-timeline-card">
      <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
        <h3 class="timeline-title" style="margin:0;border-bottom:0;padding-bottom:0;">
          Inbox
        </h3>

        <form method="POST" action="{{ route('user.notifications.mark_read') }}">
          @csrf
          <button class="btn-action btn-new-track" type="submit">Mark all as read</button>
        </form>
      </div>

      <div style="margin-top:16px;display:flex;flex-direction:column;gap:12px;">
        @forelse($notifications as $n)
          <div style="padding:14px 14px;border-radius:16px;border:1px solid rgba(255,255,255,0.10);background:{{ $n->is_read ? 'rgba(255,255,255,0.03)' : 'rgba(108,99,255,0.08)' }};">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
              <div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                  <span style="font-weight:900;color:var(--text-primary);">{{ $n->title ?: 'Message' }}</span>
                  <span style="font-size:12px;opacity:.7;">{{ strtoupper($n->type) }}</span>
                  @if(!$n->is_read)
                    <span style="font-size:11px;font-weight:800;color:var(--purple-light);">NEW</span>
                  @endif
                </div>
                <div style="margin-top:6px;color:var(--text-secondary);font-family:var(--font-body);line-height:1.6;">
                  {{ $n->message }}
                </div>
              </div>
              <div style="text-align:right;min-width:150px;">
                <div style="font-size:12px;opacity:.7;">{{ $n->created_at?->format('Y-m-d H:i') }}</div>
                @if($n->courier_id)
                  <div style="font-size:12px;margin-top:6px;opacity:.85;">Courier ID: {{ $n->courier_id }}</div>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div style="padding:22px;border-radius:18px;border:1px dashed rgba(255,255,255,0.15);color:var(--text-secondary);text-align:center;">
            No notifications yet.
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>

