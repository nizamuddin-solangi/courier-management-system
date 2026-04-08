/* ==========================================
   Rapid Route – Global Utilities (main.js)
   ========================================== */

// ---- Navbar scroll effect ----
window.addEventListener('scroll', () => {
  const navbar = document.getElementById('navbar');
  if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 20);
});

// ---- Mobile menu ----
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
if (hamburger && mobileMenu) {
  hamburger.addEventListener('click', () => mobileMenu.classList.toggle('open'));
}

// ---- Toggle password visibility ----
function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  if (!input) return;
  const isPass = input.type === 'password';
  input.type = isPass ? 'text' : 'password';
  btn.style.opacity = isPass ? '1' : '0.5';
}

// ---- Toast ----
let toastTimer = null;
function showToast(message, type = 'success') {
  let toast = document.getElementById('globalToast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'globalToast';
    toast.className = 'toast';
    document.body.appendChild(toast);
  }
  const icon = type === 'success'
    ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#43E97B" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`
    : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
  toast.innerHTML = `${icon}<span>${message}</span>`;
  toast.className = `toast ${type}`;
  setTimeout(() => toast.classList.add('show'), 10);
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 3500);
}

// ---- Count-up animation ----
function animateCount(el, target, duration = 1200) {
  const startTime = performance.now();
  const update = (now) => {
    const progress = Math.min((now - startTime) / duration, 1);
    const eased = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.floor(eased * target);
    if (progress < 1) requestAnimationFrame(update);
  };
  requestAnimationFrame(update);
}

// ---- Mock shipment data ----
const MOCK_SHIPMENTS = {
  'RPR-2024-78945': {
    id: 'RPR-2024-78945', sender: 'Rajesh Kumar', receiver: 'Priya Sharma',
    from: 'Mumbai', to: 'Delhi', type: 'Express Parcel', company: 'Rapid Route Express',
    bookDate: '2024-12-10', deliveryDate: '2024-12-13', status: 'Out for Delivery',
    timeline: [
      { event: 'Order Placed', time: 'Dec 10, 2024 – 9:00 AM', location: 'Mumbai Branch', done: true },
      { event: 'Package Picked Up', time: 'Dec 10, 2024 – 11:30 AM', location: 'Mumbai Hub', done: true },
      { event: 'In Transit – Mumbai to Delhi', time: 'Dec 11, 2024 – 6:00 AM', location: 'Highway Checkpoint', done: true },
      { event: 'Arrived at Delhi Hub', time: 'Dec 12, 2024 – 2:00 PM', location: 'Delhi Sorting Center', done: true },
      { event: 'Out for Delivery', time: 'Dec 13, 2024 – 9:15 AM', location: 'Delhi Local Branch', done: false, current: true },
      { event: 'Delivered', time: 'Expected: Dec 13, 2024 – 6:00 PM', location: 'Receiver Address', done: false }
    ]
  },
  'RPR-2024-12301': {
    id: 'RPR-2024-12301', sender: 'Anita Singh', receiver: 'Mohan Verma',
    from: 'Bengaluru', to: 'Hyderabad', type: 'Standard Parcel', company: 'Rapid Route Standard',
    bookDate: '2024-12-08', deliveryDate: '2024-12-12', status: 'Delivered',
    timeline: [
      { event: 'Order Placed', time: 'Dec 08, 2024 – 10:00 AM', location: 'Bengaluru Branch', done: true },
      { event: 'Package Picked Up', time: 'Dec 08, 2024 – 1:00 PM', location: 'Bengaluru Hub', done: true },
      { event: 'In Transit – Bengaluru to Hyderabad', time: 'Dec 09, 2024 – 7:00 AM', location: 'Transit Route', done: true },
      { event: 'Arrived at Hyderabad Hub', time: 'Dec 10, 2024 – 11:00 AM', location: 'Hyderabad Sorting Center', done: true },
      { event: 'Out for Delivery', time: 'Dec 12, 2024 – 8:30 AM', location: 'Hyderabad Local', done: true },
      { event: 'Delivered Successfully', time: 'Dec 12, 2024 – 3:45 PM', location: 'Receiver Address', done: true }
    ]
  },
  'RPR-2024-99001': {
    id: 'RPR-2024-99001', sender: 'Vijay Patel', receiver: 'Sunita Rao',
    from: 'Chennai', to: 'Pune', type: 'Fragile Goods', company: 'Rapid Route Care',
    bookDate: '2024-12-12', deliveryDate: '2024-12-16', status: 'In Transit',
    timeline: [
      { event: 'Order Placed', time: 'Dec 12, 2024 – 8:00 AM', location: 'Chennai Branch', done: true },
      { event: 'Package Picked Up', time: 'Dec 12, 2024 – 12:00 PM', location: 'Chennai Hub', done: true },
      { event: 'In Transit – Chennai to Pune', time: 'Dec 13, 2024 – 4:00 AM', location: 'Highway Route', done: false, current: true },
      { event: 'Arrival at Pune Hub', time: 'Expected: Dec 15, 2024', location: 'Pune Sorting Center', done: false },
      { event: 'Out for Delivery', time: 'Expected: Dec 16, 2024', location: 'Pune Local Branch', done: false },
      { event: 'Delivered', time: 'Expected: Dec 16, 2024', location: 'Receiver Address', done: false }
    ]
  },
  'RPR-2024-55200': {
    id: 'RPR-2024-55200', sender: 'Deepak Mehta', receiver: 'Kavya Nair',
    from: 'Kolkata', to: 'Jaipur', type: 'Documents', company: 'Rapid Route Docs',
    bookDate: '2024-12-14', deliveryDate: '2024-12-18', status: 'Pending',
    timeline: [
      { event: 'Order Placed', time: 'Dec 14, 2024 – 3:00 PM', location: 'Kolkata Branch', done: true },
      { event: 'Awaiting Pickup', time: 'Dec 15, 2024 – Morning', location: 'Kolkata Hub', done: false, current: true },
      { event: 'In Transit', time: 'TBD', location: 'En Route', done: false },
      { event: 'Arrival at Jaipur Hub', time: 'TBD', location: 'Jaipur Center', done: false },
      { event: 'Out for Delivery', time: 'TBD', location: 'Jaipur Local', done: false },
      { event: 'Delivered', time: 'Expected: Dec 18, 2024', location: 'Receiver Address', done: false }
    ]
  }
};

// ---- Shared helpers ----
function formatDate(dateStr) {
  if (!dateStr) return '—';
  return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
}

function getStatusBadge(status) {
  const map = { 'Delivered': 'status-delivered', 'In Transit': 'status-transit', 'Pending': 'status-pending', 'Out for Delivery': 'status-out' };
  const cls = map[status] || 'status-pending';
  return `<span class="status-badge ${cls}"><span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>${status}</span>`;
}

// ---- Auth ----
function getUser() { try { return JSON.parse(localStorage.getItem('rapidUser')) || null; } catch { return null; } }
function saveUser(u) { localStorage.setItem('rapidUser', JSON.stringify(u)); }
function isLoggedIn() { return !!getUser(); }
function requireAuth() { if (!isLoggedIn()) { window.location.href = 'login.html'; return false; } return true; }

// ---- Per-user shipments ----
function getUserShipments() {
  const u = getUser(); if (!u) return [];
  try { return JSON.parse(localStorage.getItem(`rapidShipments_${u.email}`)) || []; } catch { return []; }
}
function addUserShipment(s) {
  const u = getUser(); if (!u) return;
  const key = `rapidShipments_${u.email}`;
  const list = getUserShipments();
  if (!list.find(x => x.id === s.id)) { list.unshift(s); localStorage.setItem(key, JSON.stringify(list.slice(0, 30))); }
}

// ---- Print ----
function buildPrintContent(s) {
  const tl = s.timeline.map(t => `<div class="print-tl-item"><div class="print-tl-dot" style="background:${t.done ? '#6C63FF' : '#ccc'}"></div><div class="print-tl-info"><div class="print-tl-event">${t.event}</div><div class="print-tl-time">${t.time}${t.location ? ' · ' + t.location : ''}</div></div></div>`).join('');
  return `
    <div class="print-detail-row"><span class="pk">Tracking Number</span><span class="pv">${s.id}</span></div>
    <div class="print-detail-row"><span class="pk">Status</span><span class="pv">${s.status}</span></div>
    <div class="print-detail-row"><span class="pk">Sender</span><span class="pv">${s.sender}</span></div>
    <div class="print-detail-row"><span class="pk">Receiver</span><span class="pv">${s.receiver}</span></div>
    <div class="print-detail-row"><span class="pk">From</span><span class="pv">${s.from}</span></div>
    <div class="print-detail-row"><span class="pk">To</span><span class="pv">${s.to}</span></div>
    <div class="print-detail-row"><span class="pk">Courier Type</span><span class="pv">${s.type}</span></div>
    <div class="print-detail-row"><span class="pk">Company</span><span class="pv">${s.company}</span></div>
    <div class="print-detail-row"><span class="pk">Booking Date</span><span class="pv">${formatDate(s.bookDate)}</span></div>
    <div class="print-detail-row"><span class="pk">Expected Delivery</span><span class="pv">${formatDate(s.deliveryDate)}</span></div>
    <div class="print-timeline"><h3>Shipment Timeline</h3>${tl}</div>`;
}

function triggerPrint(s) {
  const d = document.getElementById('printDate'); const b = document.getElementById('printBody');
  if (d) d.textContent = new Date().toLocaleString('en-IN');
  if (b) b.innerHTML = buildPrintContent(s);
  setTimeout(() => window.print(), 100);
}
