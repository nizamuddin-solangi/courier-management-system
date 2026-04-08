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
        <a href="/user/login" class="btn-nav-login">Sign In</a>
        <a href="/user/register" class="btn-nav-signup">Register</a>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <div class="track-page-header">
    <h1>Track Your <span class="gradient-text">Shipment</span></h1>
    <p>Enter your consignment number to get real-time updates on your delivery</p>
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
      <!-- <div class="sample-ids">
        <span>Try sample IDs:</span>
        <button class="sample-id-btn" onclick="useSample('SWF-2024-78945')">SWF-2024-78945</button>
        <button class="sample-id-btn" onclick="useSample('SWF-2024-12301')">SWF-2024-12301</button>
        <button class="sample-id-btn" onclick="useSample('SWF-2024-99001')">SWF-2024-99001</button>
      </div> -->
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
  <script src="{{ asset('js/track.js') }}"></script>
</body>
</html>
