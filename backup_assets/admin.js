/* ============================================================
   COURIER MANAGEMENT SYSTEM — ADMIN DASHBOARD
   Master JavaScript
   ============================================================ */

const CITIES = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Miami', 'Seattle', 'Denver', 'Boston', 'Dallas', 'Atlanta', 'San Francisco', 'Phoenix', 'Portland', 'Nashville', 'Philadelphia'];
const FIRST_NAMES = ['James', 'Sarah', 'Michael', 'Emma', 'Robert', 'Olivia', 'William', 'Sophia', 'David', 'Isabella', 'Daniel', 'Mia', 'Alexander', 'Charlotte', 'Ethan', 'Amelia', 'Lucas', 'Harper', 'Mason', 'Evelyn'];
const LAST_NAMES = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Anderson', 'Taylor', 'Thomas', 'Hernandez', 'Moore', 'Clark', 'Lewis', 'Walker', 'Hall', 'Allen'];
const STATUSES = ['Delivered', 'Pending', 'In Transit'];
const AREAS = ['Downtown', 'Uptown', 'Midtown', 'Eastside', 'Westside', 'Suburb North', 'Suburb South', 'Industrial Zone', 'Airport Area', 'Harbor District'];

function randomFrom(arr) { return arr[Math.floor(Math.random() * arr.length)]; }
function randomName() { return `${randomFrom(FIRST_NAMES)} ${randomFrom(LAST_NAMES)}`; }
function randomTrackingId() {
  return 'CMS-' + Date.now().toString(36).toUpperCase().slice(-4) + Math.random().toString(36).toUpperCase().slice(2, 6);
}
function randomDate(start, end) {
  const d = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
  return d.toISOString().split('T')[0];
}
function randomPhone() {
  return `(${Math.floor(200+Math.random()*800)}) ${Math.floor(200+Math.random()*800)}-${Math.floor(1000+Math.random()*9000)}`;
}
function randomEmail(name) {
  const domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'mail.com'];
  return name.toLowerCase().replace(' ', '.') + '@' + randomFrom(domains);
}

// ─── INIT DATA ───────────────────────────────────────────────
function seedCouriers() {
  if (localStorage.getItem('couriers')) return;
  const couriers = [];
  const now = new Date();
  const past = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
  for (let i = 0; i < 47; i++) {
    const origin = randomFrom(CITIES);
    let dest = randomFrom(CITIES);
    while (dest === origin) dest = randomFrom(CITIES);
    couriers.push({
      id: 'c_' + i + '_' + Date.now(),
      trackingId: randomTrackingId(),
      sender: randomName(),
      receiver: randomName(),
      senderPhone: randomPhone(),
      receiverPhone: randomPhone(),
      origin,
      destination: dest,
      weight: (1 + Math.random() * 20).toFixed(1),
      packageType: randomFrom(['Parcel', 'Document', 'Fragile', 'Heavy']),
      status: randomFrom(STATUSES),
      date: randomDate(past, now)
    });
  }
  localStorage.setItem('couriers', JSON.stringify(couriers));
}

function seedAgents() {
  if (localStorage.getItem('agents')) return;
  const colors = ['#6366f1', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#ec4899', '#14b8a6'];
  const agents = [];
  for (let i = 0; i < 8; i++) {
    const name = randomName();
    agents.push({
      id: 'a_' + i + '_' + Date.now(),
      name, phone: randomPhone(), email: randomEmail(name),
      area: randomFrom(AREAS), color: colors[i % colors.length],
      deliveries: Math.floor(50 + Math.random() * 450),
      rating: (3.5 + Math.random() * 1.5).toFixed(1),
      status: Math.random() > 0.1 ? 'Active' : 'Inactive'
    });
  }
  localStorage.setItem('agents', JSON.stringify(agents));
}

function seedCustomers() {
  if (localStorage.getItem('customers')) return;
  const customers = [];
  for (let i = 0; i < 30; i++) {
    const name = randomName();
    customers.push({
      id: 'cu_' + i + '_' + Date.now(),
      name, email: randomEmail(name), phone: randomPhone(),
      city: randomFrom(CITIES), orders: Math.floor(1 + Math.random() * 50),
      status: Math.random() > 0.2 ? 'Active' : 'Inactive',
      joined: randomDate(new Date(2024, 0, 1), new Date())
    });
  }
  localStorage.setItem('customers', JSON.stringify(customers));
}

function seedNotifications() {
  if (localStorage.getItem('notifications')) return;
  const notifs = [
    { id: 1, type: 'alert', title: 'High Volume Alert', desc: 'Package volume in Downtown exceeds capacity by 15%.', time: '10 mins ago', read: false },
    { id: 2, type: 'success', title: 'Batch Delivered', desc: 'Agent James Smith delivered 12 packages in Uptown.', time: '1 hour ago', read: false },
    { id: 3, type: 'system', title: 'System Update', desc: 'CourierPro v2.1.0 update complete. New features available.', time: '2 hours ago', read: true }
  ];
  localStorage.setItem('notifications', JSON.stringify(notifs));
}

function initData() {
  seedCouriers(); seedAgents(); seedCustomers(); seedNotifications();
  if (!localStorage.getItem('smsHistory')) localStorage.setItem('smsHistory', '[]');
  
  // Guard check
  const page = document.body.dataset.page;
  if (page && page !== 'login' && localStorage.getItem('adminLoggedIn') !== 'true') {
    window.location.href = '/admin/login';
  }
}

function getData(key) { return JSON.parse(localStorage.getItem(key) || '[]'); }
function setData(key, data) { localStorage.setItem(key, JSON.stringify(data)); }

// ─── AUTHENTICATION ──────────────────────────────────────────
function handleLogin() {
  const btn = document.getElementById('loginBtn');
  const err = document.getElementById('loginError');
  err.style.display = 'none';
  btn.classList.add('loading');
  
  setTimeout(() => {
    btn.classList.remove('loading');
    const email = document.getElementById('loginEmail').value;
    const pass = document.getElementById('loginPassword').value;
    
    // Accept any test credentials for demo
    if (email.includes('@') && pass.length > 0) {
      localStorage.setItem('adminLoggedIn', 'true');
      window.location.href = '/admin/dashboard';
    } else {
      err.style.display = 'flex';
      document.getElementById('loginErrorText').textContent = 'Invalid credentials';
    }
  }, 1000);
}

function handleLogout(e) {
  if(e) e.preventDefault();
  localStorage.removeItem('adminLoggedIn');
  window.location.href = '/admin/login';
}

function togglePasswordVisibility() {
  const input = document.getElementById('loginPassword');
  const icon = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text'; icon.classList.replace('bi-eye', 'bi-eye-slash');
  } else {
    input.type = 'password'; icon.classList.replace('bi-eye-slash', 'bi-eye');
  }
}


// ─── STATUS COUNT PAGE ───────────────────────────────────────
function initStatusRings() {
  const couriers = getData('couriers');
  const d = document.getElementById('statusFilterDate').value;
  let filtered = couriers;
  if(d) filtered = couriers.filter(c => c.date === d);
  
  const total = filtered.length;
  const dev = filtered.filter(c => c.status === 'Delivered').length;
  const pen = filtered.filter(c => c.status === 'Pending').length;
  const tra = filtered.filter(c => c.status === 'In Transit').length;
  
  updateRing('ringTotal', 100);
  updateRing('ringDelivered', total ? (dev/total)*100 : 0);
  updateRing('ringPending', total ? (pen/total)*100 : 0);
  updateRing('ringTransit', total ? (tra/total)*100 : 0);
  
  document.getElementById('rvTotal').textContent = total;
  document.getElementById('rvDelivered').textContent = dev;
  document.getElementById('rvPending').textContent = pen;
  document.getElementById('rvTransit').textContent = tra;
  
  document.getElementById('sbRate').textContent = total ? ((dev/total)*100).toFixed(1)+'%' : '0%';
  document.getElementById('sbDelay').textContent = pen;
  document.getElementById('sbTransit').textContent = tra;
  document.getElementById('sbVolume').textContent = total;
  
  document.getElementById('szRate').style.width = document.getElementById('sbRate').textContent;
  document.getElementById('szDelay').style.width = document.getElementById('sbDelay').textContent + '%';
  document.getElementById('szTransit').style.width = document.getElementById('sbTransit').textContent + '%';
  document.getElementById('szVolume').style.width = '100%';
  
  initStatusCharts(filtered, total, dev, pen, tra);
}

function updateRing(id, percent) {
  const ring = document.getElementById(id);
  if(!ring) return;
  const crc = 326.7;
  const offset = crc - (percent / 100) * crc;
  ring.style.strokeDashoffset = offset;
}

let donutChart, barChart;
function initStatusCharts(filtered, total, dev, pen, tra) {
  const ctx = document.getElementById('statusDonutChart');
  const btx = document.getElementById('statusBarChart');
  if(!ctx || !btx) return;
  
  if(donutChart) donutChart.destroy();
  if(barChart) barChart.destroy();
  
  donutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Delivered', 'Pending', 'In Transit'],
      datasets: [{
        data: [dev, pen, tra],
        backgroundColor: ['#10b981', '#f59e0b', '#3b82f6'],
        borderWidth: 0,
        hoverOffset: 4
      }]
    },
    options: {
      cutout: '75%', responsive: true, maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom', labels: { color: '#94a3b8', padding: 20 } } }
    }
  });
  
  const dates = [...new Set(filtered.map(c => c.date))].sort().slice(-7);
  const vDev = dates.map(d => filtered.filter(c => c.date === d && c.status === 'Delivered').length);
  const vTra = dates.map(d => filtered.filter(c => c.date === d && c.status === 'In Transit').length);
  const vPen = dates.map(d => filtered.filter(c => c.date === d && c.status === 'Pending').length);

  barChart = new Chart(btx, {
    type: 'bar',
    data: {
      labels: dates.map(d => new Date(d).toLocaleDateString('en-US', {month:'short', day:'numeric'})),
      datasets: [
        { label: 'Delivered', data: vDev, backgroundColor: '#10b981', borderRadius: 4 },
        { label: 'In Transit', data: vTra, backgroundColor: '#3b82f6', borderRadius: 4 },
        { label: 'Pending', data: vPen, backgroundColor: '#f59e0b', borderRadius: 4 }
      ]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { stacked: true, grid: { display: false }, ticks: { color: '#94a3b8' } },
        y: { stacked: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94a3b8' } }
      }
    }
  });
}

function filterStatusData() {
  document.getElementById('spinSync').classList.add('bi-arrow-repeat');
  setTimeout(() => {
    initStatusRings();
    showToast('Status data refreshed');
  }, 500);
}

// ─── DASHBOARD LOGIC ─────────────────────────────────────────
function renderDashboardStats() {
  const couriers = getData('couriers');
  const d = couriers.filter(c => c.status === 'Delivered').length;
  const p = couriers.filter(c => c.status === 'Pending').length;
  const t = couriers.filter(c => c.status === 'In Transit').length;
  const total = couriers.length;
  
  animateCounter(document.getElementById('statTotal'), total);
  animateCounter(document.getElementById('statDelivered'), d);
  animateCounter(document.getElementById('statPending'), p);
  animateCounter(document.getElementById('statTransit'), t);
  
  const ag = getData('agents');
  animateCounter(document.getElementById('quickAgents'), ag.filter(a => a.status === 'Active').length);
  animateCounter(document.getElementById('quickCustomers'), getData('customers').length);
  const qRate = document.getElementById('quickRate');
  if(qRate) qRate.textContent = total ? ((d/total)*100).toFixed(1)+'%' : '0%';
  animateCounter(document.getElementById('quickSms'), Math.floor(total * 0.4));
  
  document.querySelectorAll('.progress-fill').forEach(el => {
    const type = el.dataset.type;
    let val = 0;
    if(type === 'total') val = 100;
    else if(type === 'delivered') val = (d/total)*100;
    else if(type === 'pending') val = (p/total)*100;
    else if(type === 'transit') val = (t/total)*100;
    el.style.width = val + '%';
  });
}

function initWelcomeBanner() {
  const el = document.getElementById('currentDate');
  if(el) el.textContent = new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}

function renderRecentShipments() {
  const tbody = document.getElementById('recentShipmentsBody');
  if(!tbody) return;
  const couriers = getData('couriers').sort((a,b)=>new Date(b.date)-new Date(a.date)).slice(0, 5);
  tbody.innerHTML = couriers.map(c => `
    <tr>
      <td><strong>${c.trackingId}</strong></td>
      <td>${c.sender}</td>
      <td>${c.destination}</td>
      <td><span class="status-badge ${c.status.toLowerCase().replace(' ', '-')}">${c.status}</span></td>
      <td style="color:var(--text-muted);font-size:13px">${c.date}</td>
    </tr>
  `).join('');
}


// ─── TOPBAR ENHANCEMENTS ──────────────────────────────────────
function toggleNotifications() {
  const drop = document.getElementById('notifDropdown');
  if(drop) drop.classList.toggle('active');
  const prof = document.getElementById('profileDropdown');
  if(prof) prof.classList.remove('active');
  renderNotifications();
}

function toggleProfileDropdown() {
  const prof = document.getElementById('profileDropdown');
  if(prof) prof.classList.toggle('active');
  const drop = document.getElementById('notifDropdown');
  if(drop) drop.classList.remove('active');
}

document.addEventListener('click', (e) => {
  if (!e.target.closest('#notifWrapper') && document.getElementById('notifDropdown')) {
    document.getElementById('notifDropdown').classList.remove('active');
  }
  if (!e.target.closest('#profileWrapper') && document.getElementById('profileDropdown')) {
    document.getElementById('profileDropdown').classList.remove('active');
  }
});

function renderNotifications() {
  const notifs = getData('notifications');
  const list = document.getElementById('notifList');
  const empty = document.getElementById('notifEmpty');
  const dot = document.getElementById('notifDot');
  if(!list) return;

  const unread = notifs.filter(n => !n.read).length;
  if(dot) dot.style.display = unread > 0 ? 'block' : 'none';

  if (notifs.length === 0) {
    list.innerHTML = '';
    empty.style.display = 'block';
  } else {
    empty.style.display = 'none';
    list.innerHTML = notifs.map(n => `
      <div class="notif-item ${n.read ? '' : 'unread'}" onclick="markNotifRead(${n.id})">
        <div class="notif-icon ${n.type}">
          <i class="bi ${n.type === 'success' ? 'bi-check-lg' : n.type === 'alert' ? 'bi-exclamation-triangle' : 'bi-info-circle'}"></i>
        </div>
        <div class="notif-content">
          <div class="notif-title">${n.title}</div>
          <div class="notif-desc">${n.desc}</div>
          <span class="notif-time">${n.time}</span>
        </div>
      </div>
    `).join('');
  }
}

function markNotifRead(id) {
  let notifs = getData('notifications');
  const idx = notifs.findIndex(n => n.id === id);
  if(idx > -1) {
    notifs[idx].read = true;
    setData('notifications', notifs);
    renderNotifications();
  }
}

function clearNotifications() {
  setData('notifications', []);
  renderNotifications();
  showToast('Notifications cleared');
}

// ─── GLOBAL SEARCH ──────────────────────────────────────────
function handleGlobalSearch() {
  const input = document.getElementById('globalSearchInput').value.toLowerCase();
  const res = document.getElementById('globalSearchResults');
  if(!res) return;
  
  if(input.length < 2) { res.style.display = 'none'; return; }
  
  const couriers = getData('couriers');
  const customers = getData('customers');
  let html = '';
  
  const matchesC = couriers.filter(c => c.trackingId.toLowerCase().includes(input) || c.sender.toLowerCase().includes(input)).slice(0,3);
  const matchesCu = customers.filter(c => c.name.toLowerCase().includes(input)).slice(0,2);
  
  if (matchesC.length > 0) {
    html += `<div style="padding:8px 12px;font-size:11px;color:var(--text-muted);text-transform:uppercase;">Shipments</div>`;
    html += matchesC.map(c => `
      <div class="search-result-item" onmousedown="window.location.href='/admin/couriers'">
        <div class="sr-icon" style="background:rgba(99,102,241,0.1);color:#818cf8;"><i class="bi bi-box-seam"></i></div>
        <div><div class="sr-title">${c.trackingId}</div><div class="sr-desc">${c.sender} → ${c.receiver}</div></div>
      </div>`).join('');
  }
  
  if (matchesCu.length > 0) {
    html += `<div style="padding:8px 12px;font-size:11px;color:var(--text-muted);text-transform:uppercase;">Customers</div>`;
    html += matchesCu.map(c => `
      <div class="search-result-item" onmousedown="window.location.href='/admin/customers'">
        <div class="sr-icon" style="background:rgba(16,185,129,0.1);color:#34d399;"><i class="bi bi-person"></i></div>
        <div><div class="sr-title">${c.name}</div><div class="sr-desc">${c.email}</div></div>
      </div>`).join('');
  }
  
  if (html === '') html = `<div style="padding:20px;text-align:center;color:var(--text-muted);font-size:13px;">No results found</div>`;
  
  res.innerHTML = html;
  res.style.display = 'block';
}

// ─── UTILS & CHARTS ───────────────────────────────────────────
let adminToastId = 0;
function showToast(message, type = 'success') {
  const container = document.getElementById('toastContainer');
  if (!container) {
    const div = document.createElement('div');
    div.id = 'toastContainer';
    div.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
    document.body.appendChild(div);
  }
  
  const id = ++adminToastId;
  const isErr = type === 'error';
  const color = isErr ? '#ef4444' : '#10b981';
  const bg = isErr ? 'rgba(239,68,68,0.1)' : 'rgba(16,185,129,0.1)';
  
  const toast = document.createElement('div');
  toast.id = 'toast-' + id;
  toast.style.cssText = `background:var(--bg-card);border-left:4px solid ${color};padding:14px 20px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.5);display:flex;align-items:center;gap:12px;transform:translateX(120%);transition:transform 0.4s cubic-bezier(0.16,1,0.3,1);color:var(--text-primary);font-size:14px;min-width:280px;`;
  
  toast.innerHTML = `
    <div style="width:24px;height:24px;border-radius:50%;background:${bg};color:${color};display:flex;align-items:center;justify-content:center;font-size:14px;"><i class="bi ${isErr?'bi-exclamation-triangle-fill':'bi-check-circle-fill'}"></i></div>
    <div style="flex:1;">${message}</div>
    <button onclick="this.parentElement.remove()" style="background:none;border:none;color:var(--text-muted);cursor:pointer;"><i class="bi bi-x-lg"></i></button>
  `;
  
  document.getElementById('toastContainer').appendChild(toast);
  setTimeout(() => toast.style.transform = 'translateX(0)', 10);
  setTimeout(() => {
    toast.style.transform = 'translateX(120%)';
    setTimeout(() => toast.remove(), 400);
  }, 4000);
}

function initDashboardChart() {
  const ctx = document.getElementById('shipmentChart');
  if(!ctx) return;
  
  const couriers = getData('couriers');
  const now = new Date();
  const last7Days = Array.from({length: 7}, (_, i) => {
    const d = new Date(now.getTime() - (6-i) * 24 * 60 * 60 * 1000);
    return d.toISOString().split('T')[0];
  });
  
  const getCount = (date, status) => couriers.filter(c => c.date === date && (status ? c.status === status : true)).length;
  
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: last7Days.map(d => new Date(d).toLocaleDateString('en-US', {weekday:'short'})),
      datasets: [
        { label: 'Delivered', data: last7Days.map(d => getCount(d, 'Delivered')), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, borderWidth: 3, pointRadius: 4, pointBackgroundColor: '#10b981' },
        { label: 'In Transit', data: last7Days.map(d => getCount(d, 'In Transit')), borderColor: '#60a5fa', tension: 0.4, borderWidth: 2, pointRadius: 0 }
      ]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { labels: { color: '#94a3b8', font: {family: 'Inter'} } } },
      scales: {
        y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94a3b8' }, beginAtZero: true },
        x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
      }
    }
  });
}

function renderActivityTimeline() {
  const container = document.getElementById('activityTimeline');
  if(!container) return;
  const couriers = getData('couriers').sort((a,b) => new Date(b.date) - new Date(a.date)).slice(0, 5);
  
  container.innerHTML = couriers.map((c, i) => {
    const sClass = c.status === 'Delivered' ? 'delivered' : c.status === 'Pending' ? 'pending' : 'transit';
    const sText = c.status === 'Delivered' ? 'Package delivered to' : c.status === 'Pending' ? 'Package prepared for' : 'Package sent from';
    const sIcon = c.status === 'Delivered' ? 'bi-check-lg' : c.status === 'Pending' ? 'bi-clock' : 'bi-truck';
    return `
      <div class="timeline-item ${sClass}">
        <div class="timeline-dot"><i class="bi ${sIcon}" style="font-size:10px;"></i></div>
        <div class="timeline-content">
          <p>${c.trackingId} — ${sText} <strong>${c.receiver}</strong></p>
          <div class="timeline-time">${i === 0 ? 'Just now' : (i*2 + ' hrs ago')}</div>
        </div>
      </div>
    `;
  }).join('');
}

function animateCounter(el, target, duration = 1500) {
  if(!el) return;
  const start = 0; const end = parseInt(target, 10); if(isNaN(end) || end === 0) { el.textContent = '0'; return; }
  const startTime = performance.now();
  function update(curr) {
    const elapsed = curr - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.floor(ease * end);
    if(progress < 1) requestAnimationFrame(update);
  }
  requestAnimationFrame(update);
}

// ─── REPORTING & CRUD ──────────────────────────────────────────
function generateReport() {
  const f = document.getElementById('reportFrom').value;
  const t = document.getElementById('reportTo').value;
  if(!f || !t) return;
  
  const rc = document.getElementById('reportResults');
  if(!rc) return;
  rc.style.display = 'block';
  
  const couriers = getData('couriers').filter(c => c.date >= f && c.date <= t);
  const total = couriers.length;
  const dev = couriers.filter(c => c.status === 'Delivered').length;
  const pen = couriers.filter(c => c.status === 'Pending').length;
  const tra = couriers.filter(c => c.status === 'In Transit').length;
  
  animateCounter(document.getElementById('rTotal'), total);
  animateCounter(document.getElementById('rDelivered'), dev);
  animateCounter(document.getElementById('rPending'), pen);
  animateCounter(document.getElementById('rTransit'), tra);
  document.getElementById('rRate').textContent = total ? ((dev/total)*100).toFixed(1)+'%' : '0%';
  
  const px = document.getElementById('reportPieChart');
  const bx = document.getElementById('reportBarChart');
  if(px && bx) {
    new Chart(px, {
      type: 'pie', data: { labels: ['Delivered','Pending','In Transit'], datasets: [{ data: [dev,pen,tra], backgroundColor: ['#10b981','#f59e0b','#3b82f6'], borderWidth: 0 }] },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: {color: '#94a3b8'} } } }
    });
    
    const dates = [...new Set(couriers.map(c=>c.date))].sort().slice(-14);
    new Chart(bx, {
      type: 'bar', data: { labels: dates.map(d => d.slice(5)), datasets: [{ label: 'Deliveries', data: dates.map(d=>couriers.filter(c=>c.date===d).length), backgroundColor: '#6366f1', borderRadius: 4 }] },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: {display:false} }, scales: { x: {grid:{display:false}, ticks:{color:'#94a3b8'}}, y: {grid:{color:'rgba(255,255,255,0.05)'}, ticks:{color:'#94a3b8'}} } }
    });
  }
  
  const lb = document.getElementById('leaderboardBody');
  if(lb) {
    const agents = getData('agents').sort((a,b)=>b.deliveries - a.deliveries).slice(0,5);
    lb.innerHTML = agents.map((a,i) => `<tr><td>#${i+1}</td><td>${a.name}</td><td>${a.deliveries}</td><td>⭐ ${a.rating}</td><td>${a.area}</td><td><div style="width:100px;height:4px;background:rgba(255,255,255,0.1);border-radius:2px;"><div style="width:${(a.rating/5)*100}%;height:100%;background:#10b981;border-radius:2px;"></div></div></td></tr>`).join('');
  }
}

function fakeDownload() {
  const btn = document.getElementById('downloadBtn');
  btn.classList.add('loading');
  setTimeout(() => {
    btn.classList.remove('loading');
    btn.classList.add('success');
    showToast('Report generated successfully.');
    setTimeout(() => btn.classList.remove('success'), 3000);
  }, 1500);
}

function exportCSV() { showToast('CSV exported successfully'); }


// ─── SMS MANAGEMENT ──────────────────────────────────────────
function lookupTracking() {
  const tid = document.getElementById('smsLookupId').value.trim();
  if(!tid) return;
  const couriers = getData('couriers');
  const c = couriers.find(c => c.trackingId === tid);
  if (c) {
    document.getElementById('smsSender').value = c.senderPhone || '';
    document.getElementById('smsReceiver').value = c.receiverPhone || '';
    document.getElementById('smsMessage').value = `Hi ${c.receiver}, your package (${c.trackingId}) from ${c.sender} is currently ${c.status}. Track online at courierpro.com`;
    updateSmsCount();
    showToast('Tracking details loaded');
  } else {
    showToast('Tracking ID not found', 'error');
  }
}

function updateSmsCount() {
  const msg = document.getElementById('smsMessage');
  const count = document.getElementById('smsCount');
  if(!msg || !count) return;
  const len = msg.value.length;
  count.textContent = `${len}/160 chars`;
  count.style.color = len > 160 ? '#f87171' : 'var(--text-muted)';
}

function updateSmsTemplate() {
  const t = document.getElementById('smsTemplate').value;
  if(!t) return;
  const tid = document.getElementById('smsLookupId').value || '[TRACKING_ID]';
  const msg = document.getElementById('smsMessage');
  
  if(t === 'delay') msg.value = `Hello, we are experiencing a slight delay with package ${tid}. We apologize for the inconvenience.`;
  else if(t === 'payment') msg.value = `Hi, please note that an outstanding payment is required for package ${tid} delivery.`;
  else if(t === 'address') msg.value = `Hello, we could not deliver package ${tid} due to an incomplete address. Please contact support.`;
  
  updateSmsCount();
}

function addSmsHistory(sender, receiver, msg, type) {
  const h = getData('smsHistory');
  h.unshift({ 
    id: Date.now(), from: sender, to: receiver, message: msg, type,
    time: new Date().toISOString(), status: 'Delivered'
  });
  setData('smsHistory', h);
}

function sendCustomSms(e) {
  e.preventDefault();
  const btn = document.getElementById('sendSmsBtn');
  btn.innerHTML = '<span class="btn-loader"></span> Sending...';
  
  setTimeout(() => {
    btn.innerHTML = '<i class="bi bi-send"></i> Send Message';
    const s = document.getElementById('smsSender').value;
    const r = document.getElementById('smsReceiver').value;
    const m = document.getElementById('smsMessage').value;
    if(m) {
      addSmsHistory(s, r, m, 'Custom');
      showToast('SMS sent successfully!');
      e.target.reset(); updateSmsCount(); renderSmsHistory();
    }
  }, 800);
}

function quickSmsAction(type) {
  showToast(`Fetching eligible shipments for '${type}' status...`);
  setTimeout(() => {
    const couriers = getData('couriers').filter(c => c.status === (type==='transit'?'In Transit':type==='delivered'?'Delivered':'Pending'));
    if(couriers.length === 0) {
      showToast('No eligible shipments found.', 'error'); return;
    }
    const c = couriers[0];
    let msg = '';
    if(type === 'transit') msg = `Hi ${c.receiver}, package ${c.trackingId} is out for delivery today!`;
    if(type === 'delivered') msg = `Hi ${c.receiver}, package ${c.trackingId} has been successfully delivered. Thank you!`;
    if(type === 'delay') msg = `Hi ${c.receiver}, package ${c.trackingId} is delayed. New ETA provided soon.`;
    if(type === 'failed') msg = `Delivery attempt failed for ${c.trackingId}. We will try again tomorrow.`;
    
    addSmsHistory('System', c.receiverPhone, msg, 'Notification');
    showToast(`Quick SMS sent for ${c.trackingId}`);
    renderSmsHistory();
  }, 600);
}

function sendBatchSms() {
  showToast('Processing batch SMS sending...');
  setTimeout(() => {
    showToast('Batch SMS processing completed!');
  }, 1500);
}

function renderSmsHistory() {
  const tbody = document.getElementById('smsHistoryBody');
  if(!tbody) return;
  const h = getData('smsHistory').slice(0, 10);
  if(h.length === 0) { tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No SMS history found</td></tr>'; return; }
  
  tbody.innerHTML = h.map(s => {
    const d = new Date(s.time);
    return `<tr>
      <td><span class="status-badge" style="background:rgba(99,102,241,0.1);color:#818cf8;">${s.type}</span></td>
      <td>${s.to}</td>
      <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${s.message}">${s.message}</td>
      <td>${d.toLocaleDateString()} ${d.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})}</td>
      <td><span class="status-badge primary">${s.status}</span></td>
    </tr>`;
  }).join('');
}

let courierCurrentPage = 1;
const itemsPerPage = 8;
function renderCouriers() {
  const tbody = document.getElementById('courierTableBody');
  if(!tbody) return;
  const couriers = getData('couriers').sort((a,b)=>new Date(b.date)-new Date(a.date));
  const search = document.getElementById('courierSearch')?.value.toLowerCase() || '';
  const filter = document.getElementById('courierStatusFilter')?.value || '';
  
  const filtered = couriers.filter(c => {
    const matchS = search === '' || c.trackingId.toLowerCase().includes(search) || c.sender.toLowerCase().includes(search) || c.receiver.toLowerCase().includes(search) || c.origin.toLowerCase().includes(search);
    const matchF = filter === '' || c.status === filter;
    return matchS && matchF;
  });
  
  const pages = Math.ceil(filtered.length / itemsPerPage) || 1;
  const start = (courierCurrentPage-1)*itemsPerPage;
  const data = filtered.slice(start, start + itemsPerPage);
  
  const pi = document.getElementById('paginationInfo');
  if(pi) pi.textContent = `Showing ${start+1} to ${Math.min(start+itemsPerPage, filtered.length)} of ${filtered.length} shipments`;
  
  if(data.length === 0) { tbody.innerHTML = '<tr><td colspan="10" style="text-align:center;color:var(--text-muted);">No shipments found</td></tr>'; } 
  else {
    tbody.innerHTML = data.map(c => `<tr>
      <td><input type="checkbox" class="courier-cb" value="${c.id}" onchange="checkBulkAction()"></td>
      <td><strong>${c.trackingId}</strong></td>
      <td>${c.sender}</td>
      <td>${c.receiver}</td>
      <td>${c.origin}</td>
      <td>${c.destination}</td>
      <td>${c.weight} kg</td>
      <td><span class="status-badge ${c.status.toLowerCase().replace(' ', '-')}">${c.status}</span></td>
      <td>${c.date}</td>
      <td>
        <div class="action-buttons">
          <button class="action-btn icon" onclick="viewCourier('${c.id}')"><i class="bi bi-eye"></i></button>
          <button class="action-btn icon" onclick="openEditCourierModal('${c.id}')"><i class="bi bi-pencil"></i></button>
          <button class="action-btn icon danger" onclick="deleteCourier('${c.id}')"><i class="bi bi-trash"></i></button>
        </div>
      </td>
    </tr>`).join('');
  }
}

function renderAgents() {
  const g = document.getElementById('agentGrid');
  if(!g) return;
  const search = document.getElementById('agentSearch')?.value.toLowerCase() || '';
  const agents = getData('agents').filter(a => search==='' || a.name.toLowerCase().includes(search) || a.area.toLowerCase().includes(search));
  
  const ab = document.getElementById('agentCountBadge');
  if (ab) ab.textContent = `${agents.length} agents`;
  if(agents.length===0) { g.innerHTML = '<div style="width:100%;text-align:center;color:var(--text-muted);">No agents found</div>'; return; }
  
  g.innerHTML = agents.map(a => `<div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="glass-card agent-card">
      <div class="agent-header">
        <div class="agent-avatar" style="background:${a.color}">${a.name.charAt(0)}</div>
        <div class="agent-status ${a.status.toLowerCase()}"><span class="status-dot"></span>${a.status}</div>
      </div>
      <div class="agent-name">${a.name}</div>
      <div class="agent-area">${a.area}</div>
      <div class="agent-stats">
        <div class="stat-box"><div>Deliveries</div><strong>${a.deliveries}</strong></div>
        <div class="stat-box"><div>Rating</div><strong>⭐ ${a.rating}</strong></div>
      </div>
      <div class="agent-actions">
        <button class="action-btn" style="flex:1" onclick="openEditAgentModal('${a.id}')"><i class="bi bi-pencil"></i> Edit</button>
        <button class="action-btn danger" onclick="deleteAgent('${a.id}')"><i class="bi bi-trash"></i></button>
      </div>
    </div>
  </div>`).join('');
}

function renderCustomers() {
  const tbody = document.getElementById('customerTableBody');
  if(!tbody) return;
  const customers = getData('customers').sort((a,b)=>new Date(b.joined)-new Date(a.joined));
  const search = document.getElementById('customerSearch')?.value.toLowerCase() || '';
  const filtered = customers.filter(c => search==='' || c.name.toLowerCase().includes(search));
  
  tbody.innerHTML = filtered.slice(0,8).map(c => `<tr>
    <td><div style="display:flex;align-items:center;gap:12px;"><div style="width:32px;height:32px;border-radius:50%;background:rgba(99,102,241,0.1);color:#818cf8;display:flex;align-items:center;justify-content:center;font-weight:600;">${c.name.charAt(0)}</div><strong>${c.name}</strong></div></td>
    <td>${c.email}</td><td>${c.phone}</td><td>${c.city}</td><td>${c.orders}</td>
    <td><span class="status-badge ${c.status.toLowerCase()}">${c.status}</span></td><td>${c.joined}</td>
    <td><div class="action-buttons"><button class="action-btn icon" onclick="viewCustomer('${c.id}')"><i class="bi bi-eye"></i></button></div></td>
  </tr>`).join('');
}

// Minimal helpers for Modals
function openAddCourierModal() { showToast('Open Add Courier Modal'); }
function openEditCourierModal(id) { showToast('Open Edit Courier Modal for ' + id); }
function openAddAgentModal() { showToast('Open Add Agent Modal'); }
function openEditAgentModal(id) { showToast('Open Edit Agent Modal for ' + id); }
function openAddCustomerModal() { showToast('Open Add Customer Modal'); }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }
function viewCourier(id) { showToast('Viewing courier details..'); }
function viewCustomer(id) { showToast('Viewing customer details..'); }
function deleteCourier(id) { showToast('Courier deletion requested'); }
function deleteAgent(id) { showToast('Agent deletion requested'); }

// ─── INITIALIZATION LOOP ────────────────────────────────────
document.addEventListener('DOMContentLoaded', initData);
