/* Rapid Route User Portal (static build)
   This is a static copy so the UI works without Vite/npm.
   Source of truth: resources/js/user/app.js
*/

document.addEventListener('DOMContentLoaded', () => {
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  const normalizeTrackingId = (value) => (value || '').trim().replace(/\s+/g, '').toUpperCase();

  const toast = (message) => {
    const el = document.createElement('div');
    el.style.position = 'fixed';
    el.style.zIndex = '9999';
    el.style.left = '50%';
    el.style.bottom = '24px';
    el.style.transform = 'translateX(-50%)';
    el.style.padding = '12px 14px';
    el.style.borderRadius = '16px';
    el.style.border = '1px solid rgba(255,255,255,0.10)';
    el.style.background = 'rgba(31,40,51,0.82)';
    el.style.backdropFilter = 'blur(16px)';
    el.style.color = '#fff';
    el.style.fontSize = '13px';
    el.style.boxShadow = '0 18px 70px -30px rgba(0,0,0,0.9)';
    el.textContent = message;
    document.body.appendChild(el);
    el.animate([{ opacity: 0, transform: 'translate(-50%, 10px)' }, { opacity: 1, transform: 'translate(-50%, 0px)' }], { duration: 220, easing: 'ease-out' });
    setTimeout(() => {
      el.animate([{ opacity: 1 }, { opacity: 0 }], { duration: 240, easing: 'ease-in' }).onfinish = () => el.remove();
    }, 1700);
  };

  const demoShipments = {
    'RPR-10001': {
      trackingId: 'RPR-10001',
      from: 'Karachi',
      to: 'Lahore',
      courierType: 'Express',
      company: 'Rapid Route',
      currentStatus: 'In Progress',
      events: [
        { status: 'Shipment Created', city: 'Karachi', timestamp: '2026-04-01 10:25', note: 'Booking confirmed' },
        { status: 'Picked Up', city: 'Karachi', timestamp: '2026-04-01 13:10', note: 'Collected from sender' },
        { status: 'In Transit', city: 'Hyderabad', timestamp: '2026-04-02 09:40', note: 'Line-haul in progress' },
        { status: 'Arrived at Branch', city: 'Lahore', timestamp: '2026-04-03 18:05', note: 'Reached destination branch' },
      ],
    },
    'RPR-10002': {
      trackingId: 'RPR-10002',
      from: 'Islamabad',
      to: 'Peshawar',
      courierType: 'Standard',
      company: 'Rapid Route',
      currentStatus: 'Delivered',
      events: [
        { status: 'Shipment Created', city: 'Islamabad', timestamp: '2026-03-28 15:02', note: 'Booking confirmed' },
        { status: 'Picked Up', city: 'Islamabad', timestamp: '2026-03-28 17:55', note: 'Collected from sender' },
        { status: 'In Transit', city: 'Taxila', timestamp: '2026-03-29 08:20', note: 'Line-haul in progress' },
        { status: 'Out for Delivery', city: 'Peshawar', timestamp: '2026-03-29 12:30', note: 'Rider assigned' },
        { status: 'Delivered', city: 'Peshawar', timestamp: '2026-03-29 15:10', note: 'Delivered to receiver' },
      ],
    },
    'RPR-10003': {
      trackingId: 'RPR-10003',
      from: 'Quetta',
      to: 'Multan',
      courierType: 'Economy',
      company: 'Rapid Route',
      currentStatus: 'Shipment',
      events: [
        { status: 'Shipment Created', city: 'Quetta', timestamp: '2026-04-06 09:12', note: 'Booking confirmed' },
      ],
    },
  };

  const statusToBadge = (status) => {
    const s = (status || '').toLowerCase();
    if (s.includes('deliver')) return { text: 'Delivered', cls: 'background: rgba(16,185,129,0.14); color: rgba(209,250,229,1); border: 1px solid rgba(52,211,153,0.22);' };
    if (s.includes('progress') || s.includes('transit') || s.includes('out for')) return { text: 'In progress', cls: 'background: rgba(14,165,233,0.14); color: rgba(224,242,254,1); border: 1px solid rgba(56,189,248,0.22);' };
    if (s.includes('ship') || s.includes('create') || s.includes('book')) return { text: 'Shipment', cls: 'background: rgba(245,158,11,0.14); color: rgba(254,243,199,1); border: 1px solid rgba(251,191,36,0.22);' };
    return { text: status || 'Unknown', cls: 'background: rgba(113,113,122,0.14); color: rgba(244,244,245,1); border: 1px solid rgba(161,161,170,0.22);' };
  };

  const renderTimeline = (container, shipment) => {
    const items = shipment.events || [];
    if (!container) return;
    container.innerHTML = '';

    items.forEach((ev, idx) => {
      const badge = statusToBadge(ev.status);

      const row = document.createElement('div');
      row.style.border = '1px solid rgba(255,255,255,0.10)';
      row.style.background = 'rgba(11,12,16,0.25)';
      row.style.borderRadius = '16px';
      row.style.padding = '14px';
      row.style.display = 'flex';
      row.style.gap = '14px';

      const left = document.createElement('div');
      left.style.display = 'flex';
      left.style.flexDirection = 'column';
      left.style.alignItems = 'center';

      const dot = document.createElement('div');
      dot.style.width = '10px';
      dot.style.height = '10px';
      dot.style.borderRadius = '999px';
      dot.style.background = idx === items.length - 1 ? '#66FCF1' : 'rgba(197,198,199,0.45)';

      const line = document.createElement('div');
      line.style.width = '2px';
      line.style.flex = '1';
      line.style.marginTop = '8px';
      line.style.background = 'rgba(102,252,241,0.15)';

      left.appendChild(dot);
      if (idx !== items.length - 1) left.appendChild(line);

      const right = document.createElement('div');
      right.style.flex = '1';
      right.style.minWidth = '0';

      const top = document.createElement('div');
      top.style.display = 'flex';
      top.style.justifyContent = 'space-between';
      top.style.gap = '10px';
      top.style.flexWrap = 'wrap';

      const title = document.createElement('div');
      title.style.color = '#fff';
      title.style.fontWeight = '700';
      title.textContent = ev.status || 'Status update';

      const time = document.createElement('div');
      time.style.fontSize = '12px';
      time.style.color = 'rgba(197,198,199,0.65)';
      time.textContent = ev.timestamp || '';

      top.appendChild(title);
      top.appendChild(time);

      const meta = document.createElement('div');
      meta.style.display = 'flex';
      meta.style.flexWrap = 'wrap';
      meta.style.gap = '8px';
      meta.style.marginTop = '8px';

      const city = document.createElement('span');
      city.style.fontSize = '12px';
      city.style.padding = '6px 10px';
      city.style.borderRadius = '999px';
      city.style.border = '1px solid rgba(255,255,255,0.10)';
      city.style.background = 'rgba(11,12,16,0.40)';
      city.style.color = 'rgba(197,198,199,0.85)';
      city.textContent = `📍 ${ev.city || '-'}`;

      const b = document.createElement('span');
      b.className = 'status-badge';
      b.textContent = badge.text;
      b.setAttribute('style', `${badge.cls} padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase;`);

      meta.appendChild(city);
      meta.appendChild(b);

      const note = document.createElement('div');
      note.style.marginTop = '8px';
      note.style.fontSize = '13px';
      note.style.color = 'rgba(197,198,199,0.75)';
      note.textContent = ev.note || '';

      right.appendChild(top);
      right.appendChild(meta);
      if (ev.note) right.appendChild(note);

      row.appendChild(left);
      row.appendChild(right);
      container.appendChild(row);
    });
  };

  // Mobile nav
  const mobileToggle = $('[data-mobile-nav-toggle]');
  const mobileNav = $('[data-mobile-nav]');
  if (mobileToggle && mobileNav) {
    mobileToggle.addEventListener('click', () => mobileNav.classList.toggle('hidden'));
    $$('a', mobileNav).forEach((a) => a.addEventListener('click', () => mobileNav.classList.add('hidden')));
  }

  // Track forms
  $$('[data-track-form]').forEach((form) => {
    const input = $('[name="tracking_id"]', form);
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const id = normalizeTrackingId(input && input.value);
      if (!id) {
        if (input) input.focus();
        toast('Enter a tracking number');
        return;
      }
      window.location.href = `/user/track/${encodeURIComponent(id)}`;
    });
  });

  // Demo tracking buttons
  $$('[data-track-demo]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const id = normalizeTrackingId(btn.getAttribute('data-track-demo'));
      const input = $('#tracking_id');
      if (input) input.value = id;
      window.location.href = `/user/track/${encodeURIComponent(id)}`;
    });
  });

  // Fake auth forms
  $$('[data-fake-auth-form]').forEach((form) => {
    const msg = $('[data-auth-message]', form);
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!msg) return;
      msg.classList.remove('hidden');
      msg.style.border = '1px solid rgba(102,252,241,0.15)';
      msg.style.background = 'rgba(11,12,16,0.35)';
      msg.style.color = '#fff';
      msg.innerHTML = `<div style="font-weight:800;">Demo only</div><div style="opacity:.8; margin-top:6px;">No backend is connected. Use Track to view shipment status.</div>`;
    });
  });

  // Status page
  const statusPage = $('[data-status-page]');
  if (statusPage) {
    const rawId = statusPage.getAttribute('data-tracking-id') || '';
    const trackingId = normalizeTrackingId(rawId);
    const shipment = demoShipments[trackingId] || demoShipments[trackingId.replace(/^RPR/, 'RPR-')] || null;

    const subtitle = $('[data-tracking-subtitle]', statusPage);
    const fromEl = $('[data-from]', statusPage);
    const toEl = $('[data-to]', statusPage);
    const badgeEl = $('[data-current-badge]', statusPage);
    const timeEl = $('[data-current-time]', statusPage);
    const timeline = $('[data-timeline]', statusPage);
    const notFound = $('[data-not-found]', statusPage);
    const progressBar = $('[data-progress-bar]', statusPage);
    const progressLabel = $('[data-progress-label]', statusPage);

    const copyBtn = $('[data-copy-tracking]', statusPage);
    if (copyBtn) {
      copyBtn.addEventListener('click', async () => {
        try {
          await navigator.clipboard.writeText(trackingId);
          toast('Tracking number copied');
        } catch {
          toast('Copy not supported');
        }
      });
    }

    const printBtn = $('[data-print]', statusPage);
    if (printBtn) printBtn.addEventListener('click', () => window.print());

    if (!shipment) {
      if (subtitle) subtitle.textContent = 'No shipment found for this tracking number.';
      if (notFound) notFound.classList.remove('hidden');
      if (badgeEl) {
        const b = statusToBadge('Unknown');
        badgeEl.textContent = b.text;
        badgeEl.setAttribute('style', b.cls);
      }
      if (progressBar) progressBar.style.width = '8%';
      if (progressLabel) progressLabel.textContent = '—';
    } else {
      if (subtitle) subtitle.textContent = `${shipment.company} • ${shipment.courierType}`;
      if (fromEl) fromEl.textContent = shipment.from;
      if (toEl) toEl.textContent = shipment.to;

      const current = shipment.currentStatus || (shipment.events && shipment.events[shipment.events.length - 1] && shipment.events[shipment.events.length - 1].status) || 'Unknown';
      const b = statusToBadge(current);
      if (badgeEl) {
        badgeEl.textContent = b.text;
        badgeEl.setAttribute('style', b.cls);
      }
      if (timeEl) {
        const lastTime = shipment.events && shipment.events[shipment.events.length - 1] && shipment.events[shipment.events.length - 1].timestamp;
        timeEl.textContent = lastTime ? `Updated: ${lastTime}` : '';
      }

      const pct = (() => {
        const s = (current || '').toLowerCase();
        if (s.includes('deliver')) return 100;
        if (s.includes('out for')) return 85;
        if (s.includes('transit') || s.includes('progress')) return 60;
        if (s.includes('pick')) return 35;
        if (s.includes('ship') || s.includes('create')) return 20;
        return 40;
      })();
      if (progressBar) progressBar.style.width = `${pct}%`;
      if (progressLabel) progressLabel.textContent = `${pct}%`;

      renderTimeline(timeline, shipment);
    }
  }
});

