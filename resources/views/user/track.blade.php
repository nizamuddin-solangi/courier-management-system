<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Track Shipment – Rapid Route</title>
  <meta name="description" content="Track your courier shipment in real-time. Enter your consignment number to get instant status updates."/>
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

  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <div class="nav-container">
      <a href="index.html" class="nav-logo">
        <div class="logo-icon">
          <svg width="24" height="24" viewBox="0 0 28 28" fill="none">
            <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="url(#tLogo)" stroke-width="2" fill="none"/>
            <defs><linearGradient id="tLogo" x1="4" y1="3" x2="24" y2="25"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs>
          </svg>
        </div>
        <span class="logo-text">Rapid<span>Route</span></span>
      </a>
      <div class="nav-links">
        <a href="/user/index" class="nav-link">Home</a>
        @if(session('user_logged_in'))
          <div class="nav-user" style="display:flex;align-items:center;gap:10px;">
            @php
              $userImage = session('user_image');
              $userName = session('user_name') ?: 'User';
            @endphp
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
          <a href="/user/register" class="btn-nav-signup">Register</a>
        @endif
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <div class="track-page-header">
    <h1>Track Your <span class="gradient-text">Shipment</span></h1>
    <p>Enter your consignment number to get real-time updates on your delivery</p>
  </div>

  <!-- Information Modal (Repurposed from Login Required) -->
  <div id="loginRequiredModal" style="display:none; position:fixed; inset:0; z-index:9999;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
    <div style="position:relative; height:100%; display:flex; align-items:center; justify-content:center; padding:18px;">
      <div style="width:min(520px, 100%); background:#101323; border:1px solid rgba(255,255,255,0.10); border-radius:24px; padding:22px; box-shadow: 0 20px 80px rgba(0,0,0,0.55);">
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
          <a href="/user/login" class="btn-search" style="text-decoration:none; padding:0.85rem 1.25rem;">
            Sign In
          </a>
          <a href="/user/register" class="btn-action btn-new-track" style="text-decoration:none;">
            Register Free
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Track Search Card -->
  <div class="track-search-section">
    <div class="track-search-card" id="trackSearchCard">
      <div class="search-label">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="url(#searchGrad)" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><defs><linearGradient id="searchGrad" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#FF6B6B"/></linearGradient></defs></svg>
        Consignment / Tracking Number
      </div>
      <div class="search-input-wrap">
        <input type="text" id="trackInput" class="track-search-input" placeholder="e.g. SWF-2024-78945" autocomplete="off" />
        <button class="btn-search" id="trackBtn" onclick="performTrack()">
          <span>Track Now</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
      <div class="sample-ids">
        <span>Try sample IDs:</span>
        <button class="sample-id-btn" onclick="useSample('SWF-2024-78945')">SWF-2024-78945</button>
        <button class="sample-id-btn" onclick="useSample('SWF-2024-12301')">SWF-2024-12301</button>
        <button class="sample-id-btn" onclick="useSample('SWF-2024-99001')">SWF-2024-99001</button>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div class="track-loading" id="trackLoading" style="display:none;">
    <div class="loading-spinner">
      <div class="spinner-ring"></div>
      <div class="spinner-ring ring-2"></div>
      <div class="spinner-ring ring-3"></div>
    </div>
    <p>Fetching shipment details...</p>
  </div>

  <!-- Result Section -->
  <div class="track-result-section" id="trackResult" style="display:none;">
    <!-- Summary Card -->
    <div class="result-summary-card" id="resultSummary">
      <div class="result-header">
        <div class="result-id-section">
          <span class="result-label">Tracking Number</span>
          <span class="result-id" id="resultTrackId"></span>
        </div>
        <div class="result-status-badge" id="resultStatusBadge"></div>
      </div>
      <div class="result-details-grid">
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <div>
            <span class="detail-key">From</span>
            <span class="detail-val" id="resultFrom"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <div>
            <span class="detail-key">To</span>
            <span class="detail-val" id="resultTo"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <div>
            <span class="detail-key">Sender</span>
            <span class="detail-val" id="resultSender"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <div>
            <span class="detail-key">Receiver</span>
            <span class="detail-val" id="resultReceiver"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          <div>
            <span class="detail-key">Booking Date</span>
            <span class="detail-val" id="resultBookDate"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          <div>
            <span class="detail-key">Expected Delivery</span>
            <span class="detail-val" id="resultDeliveryDate"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
          <div>
            <span class="detail-key">Courier Type</span>
            <span class="detail-val" id="resultType"></span>
          </div>
        </div>
        <div class="result-detail">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <div>
            <span class="detail-key">Courier Company</span>
            <span class="detail-val" id="resultCompany"></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Details Table (dummy UI preview) -->
    <div class="result-timeline-card" id="resultTableCard">
      <h3 class="timeline-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="url(#tblGrad)" stroke-width="2">
          <path d="M3 3h18v18H3z"/><path d="M3 9h18"/><path d="M9 21V9"/>
          <defs><linearGradient id="tblGrad" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#43E97B"/></linearGradient></defs>
        </svg>
        Shipment Details
      </h3>
      <div style="overflow:auto;">
        <table style="width:100%; border-collapse:collapse;">
          <thead>
            <tr>
              <th colspan="4" style="text-align:left; padding:12px 10px; font-size:12px; letter-spacing:.06em; text-transform:uppercase; opacity:.75;">
                Key details (2 columns)
              </th>
            </tr>
          </thead>
          <tbody id="detailsTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- Live Route (Animated) -->
    <div class="result-timeline-card" id="resultRouteCard">
      <h3 class="timeline-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="url(#rtGrad)" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
          <defs><linearGradient id="rtGrad" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#43E97B"/></linearGradient></defs>
        </svg>
        Live Route
      </h3>

      <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:10px;">
          <span style="font-size:12px;letter-spacing:.06em;text-transform:uppercase;opacity:.7;">From</span>
          <span id="routeFromLabel" style="font-weight:800;color:var(--text-primary);"></span>
        </div>
        <div style="opacity:.6;">→</div>
        <div style="display:flex;align-items:center;gap:10px;">
          <span style="font-size:12px;letter-spacing:.06em;text-transform:uppercase;opacity:.7;">To</span>
          <span id="routeToLabel" style="font-weight:800;color:var(--text-primary);"></span>
        </div>
      </div>

      <div style="position:relative;border-radius:18px;border:1px solid var(--border-glass);background:rgba(10,10,26,0.25);overflow:hidden;">
        <svg id="routeSvg" viewBox="0 0 640 220" width="100%" height="220" style="display:block;">
          <defs>
            <linearGradient id="routeLine" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#6C63FF" stop-opacity="0.95"/>
              <stop offset="1" stop-color="#43E97B" stop-opacity="0.95"/>
            </linearGradient>
            <filter id="routeGlow" x="-50%" y="-50%" width="200%" height="200%">
              <feGaussianBlur stdDeviation="3" result="blur"/>
              <feMerge>
                <feMergeNode in="blur"/>
                <feMergeNode in="SourceGraphic"/>
              </feMerge>
            </filter>
          </defs>

          <!-- subtle grid -->
          <g opacity="0.14">
            <path d="M0 60H640M0 110H640M0 160H640" stroke="white" stroke-width="1"/>
            <path d="M120 0V220M260 0V220M400 0V220M540 0V220" stroke="white" stroke-width="1"/>
          </g>

          <!-- route path -->
          <path id="routePathBg" d="M70 150 C 190 40, 360 210, 570 90" fill="none" stroke="rgba(255,255,255,0.18)" stroke-width="10" stroke-linecap="round"/>
          <path id="routePath" d="M70 150 C 190 40, 360 210, 570 90" fill="none" stroke="url(#routeLine)" stroke-width="6" stroke-linecap="round" filter="url(#routeGlow)"/>

          <!-- start/end markers -->
          <g id="routeMarkers" filter="url(#routeGlow)">
            <circle cx="70" cy="150" r="10" fill="#6C63FF"/>
            <circle cx="70" cy="150" r="18" fill="#6C63FF" opacity="0.18">
              <animate attributeName="r" values="12;20;12" dur="2.2s" repeatCount="indefinite"/>
              <animate attributeName="opacity" values="0.22;0.10;0.22" dur="2.2s" repeatCount="indefinite"/>
            </circle>

            <circle cx="570" cy="90" r="10" fill="#43E97B"/>
            <circle cx="570" cy="90" r="18" fill="#43E97B" opacity="0.18">
              <animate attributeName="r" values="12;20;12" dur="2.2s" repeatCount="indefinite"/>
              <animate attributeName="opacity" values="0.22;0.10;0.22" dur="2.2s" repeatCount="indefinite"/>
            </circle>
          </g>

          <!-- premium cargo truck -->
          <defs>
            <linearGradient id="truckCab" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#6C63FF"/>
              <stop offset="1" stop-color="#FF6B6B"/>
            </linearGradient>
            <linearGradient id="truckBox" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="rgba(255,255,255,0.18)"/>
              <stop offset="1" stop-color="rgba(255,255,255,0.06)"/>
            </linearGradient>
            <filter id="truckShadow" x="-50%" y="-50%" width="200%" height="200%">
              <feGaussianBlur stdDeviation="2.2" result="b"/>
              <feOffset dx="0" dy="2" result="o"/>
              <feMerge>
                <feMergeNode in="o"/>
                <feMergeNode in="SourceGraphic"/>
              </feMerge>
            </filter>
          </defs>

          <g id="busGroup" transform="translate(70 150)">
            <!-- slight bob for premium feel -->
            <animateTransform attributeName="transform" additive="sum" type="translate"
                              values="0 0; 0 -1.4; 0 0" dur="1.35s" repeatCount="indefinite"/>
            <g id="busRotate" filter="url(#truckShadow)">
              <!-- trailer box -->
              <rect x="-54" y="-30" width="74" height="40" rx="10" fill="rgba(11,12,16,0.92)"/>
              <rect x="-52" y="-28" width="70" height="36" rx="9" fill="url(#truckBox)"/>
              <!-- subtle stripes -->
              <path d="M-46 -20 H 8" stroke="rgba(67,233,123,0.55)" stroke-width="3" stroke-linecap="round"/>
              <path d="M-46 -12 H 2" stroke="rgba(108,99,255,0.55)" stroke-width="3" stroke-linecap="round"/>

              <!-- cab -->
              <path d="M20 -22 h22 c10 0 18 8 18 18v12H20z" fill="url(#truckCab)"/>
              <path d="M20 -22 h22 c10 0 18 8 18 18v12H20z" fill="white" opacity="0.08"/>

              <!-- windshield -->
              <rect x="30" y="-18" width="18" height="14" rx="4" fill="rgba(255,255,255,0.22)"/>
              <rect x="32" y="-16" width="14" height="10" rx="3" fill="rgba(255,255,255,0.10)"/>

              <!-- headlight -->
              <circle cx="58" cy="2" r="3" fill="rgba(255,255,255,0.85)"/>
              <circle cx="58" cy="2" r="7" fill="rgba(255,255,255,0.12)"/>

              <!-- chassis -->
              <rect x="-58" y="6" width="126" height="10" rx="5" fill="rgba(255,255,255,0.10)"/>

              <!-- wheels -->
              <g>
                <circle cx="-30" cy="18" r="10" fill="#0B0C10"/>
                <circle cx="-30" cy="18" r="6" fill="#111827"/>
                <circle cx="-30" cy="18" r="3" fill="#9CA3AF"/>
                <circle cx="10" cy="18" r="10" fill="#0B0C10"/>
                <circle cx="10" cy="18" r="6" fill="#111827"/>
                <circle cx="10" cy="18" r="3" fill="#9CA3AF"/>
                <circle cx="46" cy="18" r="10" fill="#0B0C10"/>
                <circle cx="46" cy="18" r="6" fill="#111827"/>
                <circle cx="46" cy="18" r="3" fill="#9CA3AF"/>
              </g>
            </g>
          </g>
        </svg>
      </div>
      <div id="routeHint" style="margin-top:10px;color:var(--text-secondary);font-family:var(--font-body);font-size:0.9rem;opacity:.9;"></div>
    </div>

    <!-- Timeline -->
    <div class="result-timeline-card" id="resultTimeline">
      <h3 class="timeline-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="url(#tlGrad)" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/><defs><linearGradient id="tlGrad" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#6C63FF"/><stop offset="1" stop-color="#43E97B"/></linearGradient></defs></svg>
        Shipment Timeline
      </h3>
      <div class="timeline-list" id="timelineList"></div>
    </div>

    <!-- Action Buttons -->
    <div class="result-actions">
      <button class="btn-action btn-print" onclick="printStatus()" id="printBtn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print Status
      </button>
      <button class="btn-action btn-share" onclick="downloadReport()" id="downloadBtn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Download Report
      </button>
      <button class="btn-action btn-share" onclick="shareStatus()" id="shareBtn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
        Share
      </button>
      <button class="btn-action btn-new-track" onclick="resetTrack()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
        Track Another
      </button>
    </div>
  </div>

  <!-- Not Found State -->
  <div class="track-not-found" id="trackNotFound" style="display:none;">
    <div class="not-found-icon">
      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="url(#nfGrad)" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M11 8v3M11 14h.01"/><defs><linearGradient id="nfGrad" x1="0" y1="0" x2="24" y2="24"><stop stop-color="#FF6B6B"/><stop offset="1" stop-color="#F7971E"/></linearGradient></defs></svg>
    </div>
    <h3>Shipment Not Found</h3>
    <p>We couldn't find a shipment with that tracking number. Please double-check and try again.</p>
    <button class="btn-primary" onclick="resetTrack()">Try Again</button>
  </div>

  <!-- Printable View (hidden) -->
  <div id="printableArea" class="printable-area">
    <div class="print-header">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
        <svg width="36" height="36" viewBox="0 0 28 28" fill="none">
          <path d="M4 8L14 3L24 8V20L14 25L4 20V8Z" stroke="#6C63FF" stroke-width="2" fill="none"/>
        </svg>
        <span style="font-size:24px;font-weight:800;color:#1a1a2e">Rapid<span style="color:#6C63FF">Route</span></span>
      </div>
      <h2>Official Shipment Status Report</h2>
      <p>Generated on: <span id="printDate"></span></p>
    </div>
    <div class="print-body" id="printBody"></div>
    <div class="print-footer">
      <p>This is a computer-generated document. Rapid Route – Track. Deliver. Trust.</p>
    </div>
  </div>

  <script src="{{ asset('js/main.js') }}"></script>
  <!-- Frontend-only dummy tracking (for UX/UI preview) -->
  <script>
    (function () {
      const $ = (id) => document.getElementById(id);
      const IS_LOGGED_IN = @json((bool) session('user_logged_in'));

      const showLoginRequired = () => {
        const m = $("loginRequiredModal");
        if (m) m.style.display = "";
      };
      window.closeLoginRequired = function () {
        const m = $("loginRequiredModal");
        if (m) m.style.display = "none";
      };

      const el = {
        input: $("trackInput"),
        loading: $("trackLoading"),
        result: $("trackResult"),
        notFound: $("trackNotFound"),
        resultTrackId: $("resultTrackId"),
        statusBadge: $("resultStatusBadge"),
        from: $("resultFrom"),
        to: $("resultTo"),
        sender: $("resultSender"),
        receiver: $("resultReceiver"),
        bookDate: $("resultBookDate"),
        deliveryDate: $("resultDeliveryDate"),
        type: $("resultType"),
        company: $("resultCompany"),
        timeline: $("timelineList"),
        detailsBody: $("detailsTableBody"),
        routeFromLabel: $("routeFromLabel"),
        routeToLabel: $("routeToLabel"),
        routePath: $("routePath"),
        routeSvg: $("routeSvg"),
        busGroup: $("busGroup"),
        busRotate: $("busRotate"),
        routeHint: $("routeHint"),
        printDate: $("printDate"),
        printBody: $("printBody"),
      };

      let routeAnimRaf = null;

      const formatDate = (iso) => {
        try {
          return new Date(iso).toLocaleString(undefined, { year: "numeric", month: "short", day: "2-digit", hour: "2-digit", minute: "2-digit" });
        } catch {
          return iso;
        }
      };

      const statusLabel = (status) => {
        const s = String(status || "").toLowerCase();
        if (s === "pending") return "Pending";
        if (s === "in_transit") return "In Transit";
        if (s === "delivered") return "Delivered";
        if (s === "cancelled") return "Cancelled";
        return status || "Unknown";
      };

      const toUiData = (payload) => {
        const c = payload?.courier || {};
        const timeline = Array.isArray(payload?.timeline) ? payload.timeline : [];

        const expectedDelivery =
          c.delivery_date
            ? (c.delivery_time ? `${c.delivery_date} ${c.delivery_time}` : c.delivery_date)
            : null;

        return {
          trackingId: c.tracking_number || "",
          status: { key: statusLabel(c.status), raw: (c.status || "").toString().toLowerCase() },
          from: c.from_city || "",
          to: c.to_city || "",
          sender: c.sender_name || "",
          receiver: c.receiver_name || "",
          bookingDate: c.created_at || "",
          expectedDelivery: expectedDelivery || "",
          courierType: c.parcel_type || "",
          courierCompany: c.agent?.name ? `Agent: ${c.agent.name}` : "",
          weight: c.weight != null ? `${c.weight} kg` : "",
          steps: timeline.map((t) => ({
            title: t.title || "Update",
            location: t.location || "",
            at: t.at || "",
            meta: t.meta || "",
          })),
          raw: c,
        };
      };

      const setVisible = (show) => {
        el.loading.style.display = show.loading ? "" : "none";
        el.result.style.display = show.result ? "" : "none";
        el.notFound.style.display = show.notFound ? "" : "none";
      };

      const renderStatusBadge = (status) => {
        const raw = (status?.raw || "").toString().toLowerCase();
        const cls =
          raw === "delivered" ? "status-delivered" :
          raw === "in_transit" ? "status-in-transit" :
          raw === "cancelled" ? "status-cancelled" :
          "status-pending";

        el.statusBadge.className = `result-status-badge ${cls}`;
        el.statusBadge.textContent = status?.key || "Unknown";
      };

      const renderTimeline = (steps) => {
        el.timeline.innerHTML = steps
          .map((s, idx) => {
            const active = idx === steps.length - 1;
            return `
              <div class="timeline-item ${active ? "active" : ""}">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                  <div class="timeline-top">
                    <span class="timeline-status">${s.title}</span>
                    <span class="timeline-time">${formatDate(s.at)}</span>
                  </div>
                  <div class="timeline-meta">
                    <span class="timeline-loc">${s.location}</span>
                    <span class="timeline-note">${s.meta}</span>
                  </div>
                </div>
              </div>
            `;
          })
          .join("");
      };

      const renderDetailsTable = (d) => {
        const c = d.raw || {};
        const rows = [
          ["Tracking ID", d.trackingId],
          ["Current Status", d.status?.key],
          ["From City", c.from_city],
          ["To City", c.to_city],
          ["Sender Name", c.sender_name],
          ["Sender Phone", c.sender_phone],
          ["Sender Address", c.sender_address],
          ["Receiver Name", c.receiver_name],
          ["Receiver Phone", c.receiver_phone],
          ["Receiver Address", c.receiver_address],
          ["Booking Date", c.created_at ? formatDate(c.created_at) : ""],
          [
            "Expected Delivery",
            c.delivery_date
              ? (c.delivery_time ? `${c.delivery_date} ${c.delivery_time}` : c.delivery_date)
              : "",
          ],
          ["Parcel Type", c.parcel_type],
          ["Weight", c.weight != null ? `${c.weight} kg` : ""],
          ["Price", c.price != null ? `PKR ${c.price}` : ""],
          ["Assigned Agent", c.agent?.name || ""],
          ["Last Updated", c.updated_at ? formatDate(c.updated_at) : ""],
        ].filter(([, v]) => {
          const val = (v ?? "").toString().trim();
          return val !== "";
        });

        const esc = (s) => String(s).replaceAll("<", "&lt;").replaceAll(">", "&gt;");

        const pairRows = [];
        for (let i = 0; i < rows.length; i += 2) {
          const a = rows[i];
          const b = rows[i + 1] || null;
          pairRows.push([a, b]);
        }

        el.detailsBody.innerHTML = pairRows
          .map(([a, b]) => {
            const [k1, v1] = a;
            const k2 = b ? b[0] : "";
            const v2 = b ? b[1] : "";

            return `
              <tr>
                <td style="padding:10px; border-top:1px solid rgba(255,255,255,.08); font-weight:700; width:18%; white-space:nowrap;">${esc(k1)}</td>
                <td style="padding:10px; border-top:1px solid rgba(255,255,255,.08); opacity:.92; width:32%;">${esc(v1)}</td>
                <td style="padding:10px; border-top:1px solid rgba(255,255,255,.08); font-weight:700; width:18%; white-space:nowrap;">${esc(k2)}</td>
                <td style="padding:10px; border-top:1px solid rgba(255,255,255,.08); opacity:.92; width:32%;">${esc(v2)}</td>
              </tr>
            `;
          })
          .join("");
      };

      const renderSummary = (d) => {
        el.resultTrackId.textContent = d.trackingId;
        renderStatusBadge(d.status);
        el.from.textContent = d.from;
        el.to.textContent = d.to;
        el.sender.textContent = d.sender;
        el.receiver.textContent = d.receiver;
        el.bookDate.textContent = formatDate(d.bookingDate);
        el.deliveryDate.textContent = formatDate(d.expectedDelivery);
        el.type.textContent = d.courierType;
        el.company.textContent = d.courierCompany;
      };

      const renderPrintable = (d) => {
        if (!el.printDate || !el.printBody) return;
        el.printDate.textContent = new Date().toLocaleString();
        el.printBody.innerHTML = `
          <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin:16px 0;">
            <div><strong>Tracking ID:</strong> ${d.trackingId}</div>
            <div><strong>Status:</strong> ${d.status.key}</div>
            <div><strong>From:</strong> ${d.from}</div>
            <div><strong>To:</strong> ${d.to}</div>
            <div><strong>Sender:</strong> ${d.sender}</div>
            <div><strong>Receiver:</strong> ${d.receiver}</div>
          </div>
          <h3 style="margin:18px 0 10px;">Timeline</h3>
          <ol style="margin:0;padding-left:18px;">
            ${d.steps.map((s) => `<li style="margin:6px 0;"><strong>${s.title}</strong> — ${s.location} <span style="opacity:.8">(${formatDate(s.at)})</span></li>`).join("")}
          </ol>
        `;
      };

      const easeInOut = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

      const statusProgress = (raw) => {
        const s = (raw || "").toString().toLowerCase();
        if (s === "pending") return { mode: "static", p: 0.06, hint: "Shipment is pending. Vehicle is preparing to depart." };
        if (s === "in_transit") return { mode: "animate", p: 0.0, hint: "In transit. Vehicle is moving along the route." };
        if (s === "delivered") return { mode: "static", p: 0.98, hint: "Delivered. Vehicle has reached the destination." };
        if (s === "cancelled") return { mode: "static", p: 0.42, hint: "Cancelled. Route tracking is stopped." };
        return { mode: "animate", p: 0.0, hint: "Live route preview." };
      };

      const setBusColorForStatus = (raw) => {
        const s = (raw || "").toString().toLowerCase();
        if (!el.busRotate) return;
        const windows = el.busRotate.querySelectorAll("rect");
        if (s === "cancelled") {
          windows.forEach((r) => r.setAttribute("opacity", "0.25"));
          return;
        }
        windows.forEach((r) => r.setAttribute("opacity", r.getAttribute("opacity") || "0.9"));
      };

      const renderRoute = (d) => {
        if (!el.routeFromLabel || !el.routeToLabel || !el.busGroup || !el.routePath) return;

        el.routeFromLabel.textContent = (d.raw?.from_city || d.from || "").toString();
        el.routeToLabel.textContent = (d.raw?.to_city || d.to || "").toString();

        if (routeAnimRaf) {
          cancelAnimationFrame(routeAnimRaf);
          routeAnimRaf = null;
        }

        const path = el.routePath;
        const len = path.getTotalLength();
        const st = statusProgress(d.status?.raw);
        if (el.routeHint) el.routeHint.textContent = st.hint;
        setBusColorForStatus(d.status?.raw);

        const placeAt = (p) => {
          const clamped = Math.max(0.01, Math.min(0.99, p));
          const pt = path.getPointAtLength(len * clamped);
          const pt2 = path.getPointAtLength(len * Math.min(0.99, clamped + 0.002));
          const angle = Math.atan2(pt2.y - pt.y, pt2.x - pt.x) * (180 / Math.PI);
          el.busGroup.setAttribute("transform", `translate(${pt.x} ${pt.y})`);
          if (el.busRotate) el.busRotate.setAttribute("transform", `rotate(${angle})`);
        };

        if (st.mode === "static") {
          placeAt(st.p);
          return;
        }

        const durationMs = 4200;
        const start = performance.now();
        const tick = (now) => {
          const t = ((now - start) % durationMs) / durationMs;
          placeAt(easeInOut(t));
          routeAnimRaf = requestAnimationFrame(tick);
        };
        routeAnimRaf = requestAnimationFrame(tick);
      };

      window.useSample = function (id) {
        el.input.value = id;
        window.performTrack();
      };

      window.performTrack = function () {
        if (!IS_LOGGED_IN) {
          showLoginRequired();
          return;
        }
        const trackingId = (el.input?.value || "").trim();
        if (!trackingId) {
          setVisible({ loading: false, result: false, notFound: true });
          return;
        }

        setVisible({ loading: true, result: false, notFound: false });

        const url = `/user/track/lookup?tracking_number=${encodeURIComponent(trackingId)}`;
        fetch(url, { headers: { "Accept": "application/json" } })
          .then(async (res) => {
            const body = await res.json().catch(() => ({}));
            if (!res.ok) {
              if (res.status === 401) {
                showLoginRequired();
                const err = new Error(body?.message || "Please login first to track.");
                err.status = res.status;
                throw err;
              }
              const err = new Error(body?.message || "Shipment not found");
              err.status = res.status;
              throw err;
            }
            return body;
          })
          .then((payload) => {
            const d = toUiData(payload);
            renderSummary(d);
            renderDetailsTable(d);
            renderRoute(d);
            renderTimeline(d.steps);
            renderPrintable(d);
            setVisible({ loading: false, result: true, notFound: false });
          })
          .catch(() => {
            setVisible({ loading: false, result: false, notFound: true });
          });
      };

      window.resetTrack = function () {
        if (el.input) el.input.value = "";
        setVisible({ loading: false, result: false, notFound: false });
        if (routeAnimRaf) {
          cancelAnimationFrame(routeAnimRaf);
          routeAnimRaf = null;
        }
      };

      window.printStatus = function () {
        // Uses the already-present printable markup.
        window.print();
      };

      window.shareStatus = async function () {
        const trackingId = (el.input?.value || "").trim();
        const text = trackingId ? `Tracking update: ${trackingId}` : "Tracking update";
        if (navigator.share) {
          try {
            await navigator.share({ title: "Shipment Tracking", text });
            return;
          } catch (_) {}
        }
        try {
          await navigator.clipboard.writeText(text);
          alert("Copied to clipboard.");
        } catch (_) {
          alert(text);
        }
      };

      window.downloadReport = function () {
        if (!IS_LOGGED_IN) {
          showLoginRequired();
          return;
        }
        const trackingId = (el.input?.value || "").trim();
        if (!trackingId) {
          alert("Please enter a tracking number first.");
          return;
        }
        const url = `/user/track/download?tracking_number=${encodeURIComponent(trackingId)}`;
        window.location.href = url;
      };

      // Auto-track on load
      const urlParams = new URLSearchParams(window.location.search);
      const trackingId = urlParams.get('id');
      if (trackingId && el.input) {
        el.input.value = trackingId;
        window.performTrack();
      }

      // Enter key support
      if (el.input) {
        el.input.addEventListener("keydown", (e) => {
          if (e.key === "Enter") window.performTrack();
        });
      }
    })();
  </script>
</body>
</html>
