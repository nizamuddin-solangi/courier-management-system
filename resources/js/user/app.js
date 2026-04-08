// User Portal - Frontend-only interactivity (no backend)
document.addEventListener('DOMContentLoaded', () => {
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    const normalizeTrackingId = (value) => (value || '').trim().replace(/\s+/g, '').toUpperCase();

    const toast = (message) => {
        const el = document.createElement('div');
        el.className = 'fixed z-[80] bottom-6 left-1/2 -translate-x-1/2 px-4 py-3 rounded-2xl border border-white/10 bg-bg-card/80 backdrop-blur-xl text-sm text-white shadow-[0_18px_70px_-30px_rgba(0,0,0,0.9)]';
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
        if (s.includes('deliver')) return { text: 'Delivered', cls: 'bg-emerald-500/15 text-emerald-200 border border-emerald-400/20' };
        if (s.includes('progress') || s.includes('transit') || s.includes('out for')) return { text: 'In progress', cls: 'bg-sky-500/15 text-sky-200 border border-sky-400/20' };
        if (s.includes('ship') || s.includes('create') || s.includes('book')) return { text: 'Shipment', cls: 'bg-amber-500/15 text-amber-200 border border-amber-400/20' };
        return { text: status || 'Unknown', cls: 'bg-zinc-500/15 text-zinc-200 border border-zinc-400/20' };
    };

    const renderTimeline = (container, shipment) => {
        const items = shipment.events || [];
        if (!container) return;
        container.innerHTML = '';

        const wrap = document.createElement('div');
        wrap.className = 'space-y-3';

        items.forEach((ev, idx) => {
            const badge = statusToBadge(ev.status);
            const row = document.createElement('div');
            row.className = 'rounded-2xl border border-white/10 bg-bg-deep/25 p-4 flex gap-4';

            const left = document.createElement('div');
            left.className = 'flex flex-col items-center';

            const dot = document.createElement('div');
            dot.className = 'h-3 w-3 rounded-full';
            dot.style.background = idx === items.length - 1 ? '#66FCF1' : 'rgba(197,198,199,0.45)';

            const line = document.createElement('div');
            line.className = 'flex-1 w-px mt-2';
            line.style.background = 'rgba(102,252,241,0.15)';

            left.appendChild(dot);
            if (idx !== items.length - 1) left.appendChild(line);

            const right = document.createElement('div');
            right.className = 'flex-1 min-w-0';

            const top = document.createElement('div');
            top.className = 'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2';

            const title = document.createElement('div');
            title.className = 'text-white font-semibold';
            title.textContent = ev.status || 'Status update';

            const time = document.createElement('div');
            time.className = 'text-xs text-text-main/60';
            time.textContent = ev.timestamp || '';

            top.appendChild(title);
            top.appendChild(time);

            const meta = document.createElement('div');
            meta.className = 'mt-1 flex flex-wrap items-center gap-2';

            const city = document.createElement('span');
            city.className = 'text-xs px-3 py-1 rounded-full border border-white/10 bg-bg-deep/40 text-text-main/80';
            city.innerHTML = `<i class="bi bi-geo-alt"></i> ${ev.city || '-'}`;

            const b = document.createElement('span');
            b.className = `status-badge ${badge.cls}`;
            b.textContent = badge.text;

            meta.appendChild(city);
            meta.appendChild(b);

            const note = document.createElement('div');
            note.className = 'mt-2 text-sm text-text-main/75';
            note.textContent = ev.note || '';

            right.appendChild(top);
            right.appendChild(meta);
            if (ev.note) right.appendChild(note);

            row.appendChild(left);
            row.appendChild(right);
            wrap.appendChild(row);
        });

        container.appendChild(wrap);
    };

    // Mobile nav
    const mobileToggle = $('[data-mobile-nav-toggle]');
    const mobileNav = $('[data-mobile-nav]');
    if (mobileToggle && mobileNav) {
        mobileToggle.addEventListener('click', () => {
            mobileNav.classList.toggle('hidden');
        });
        $$('a', mobileNav).forEach((a) => a.addEventListener('click', () => mobileNav.classList.add('hidden')));
    }

    // Track forms (home + track page)
    $$('[data-track-form]').forEach((form) => {
        const input = $('[name="tracking_id"]', form);
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const id = normalizeTrackingId(input?.value);
            if (!id) {
                input?.focus();
                input?.classList.add('border-red-400/40');
                setTimeout(() => input?.classList.remove('border-red-400/40'), 900);
                return;
            }
            window.location.href = `/user/track/${encodeURIComponent(id)}`;
        });

        // Focus styling
        if (input) {
            input.addEventListener('focus', () => input.classList.remove('border-red-400/40'));
        }
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

    // Fake auth forms (login/register)
    $$('[data-fake-auth-form]').forEach((form) => {
        const msg = $('[data-auth-message]', form);
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!msg) return;
            msg.classList.remove('hidden');
            msg.classList.add('border-brand/15');
            msg.innerHTML = `<div class="text-white font-semibold">Demo only</div><div class="text-text-main/75 mt-1">No backend is connected. Use the Track page to view shipment status.</div>`;
        });
    });

    // Status page renderer
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
                    toast('Copy not supported in this browser');
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
                badgeEl.className = `status-badge ${b.cls}`;
            }
            if (progressBar) progressBar.style.width = '8%';
            if (progressLabel) progressLabel.textContent = '—';
        } else {
            if (subtitle) subtitle.textContent = `${shipment.company} • ${shipment.courierType}`;
            if (fromEl) fromEl.textContent = shipment.from;
            if (toEl) toEl.textContent = shipment.to;

            const current = shipment.currentStatus || (shipment.events?.[shipment.events.length - 1]?.status ?? 'Unknown');
            const b = statusToBadge(current);
            if (badgeEl) {
                badgeEl.textContent = b.text;
                badgeEl.className = `status-badge ${b.cls}`;
            }
            if (timeEl) {
                const lastTime = shipment.events?.[shipment.events.length - 1]?.timestamp || '';
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
