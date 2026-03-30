@extends('admin.layouts.admin')

@section('title', 'Update Profile')

@section('content')

{{-- All custom styles scoped to this page --}}
<style>
    .profile-wrap { max-width: 1200px; margin: 0 auto; }
    
    /* ── Main Layout Grid ── */
    .profile-grid { display: grid; grid-template-columns: 350px 1fr; gap: 24px; align-items: start; }
    @media (max-width: 1024px) { .profile-grid { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .pcard {
        background: rgba(31,40,51,0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 20px;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
    }
    
    /* ── Identity Sidebar Card ── */
    .identity-card { overflow: hidden; position: relative; }
    .identity-cover {
        height: 120px;
        background: linear-gradient(135deg, #1a3a38 0%, #0d1f2d 50%, #0b1a24 100%);
        position: relative;
    }
    .identity-orb-top {
        position: absolute; top: -40px; right: -40px; width: 150px; height: 150px;
        background: radial-gradient(circle, #66FCF1, transparent); opacity: 0.3; border-radius: 50%;
    }
    .identity-orb-bot {
        position: absolute; bottom: -40px; left: -40px; width: 120px; height: 120px;
        background: radial-gradient(circle, #45A29E, transparent); opacity: 0.2; border-radius: 50%;
    }

    /* ── Section badges ── */
    .sec-badge {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    /* ── Form fields ── */
    .form-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #45A29E;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .form-input {
        width: 100%;
        background: rgba(0,0,0,0.4);
        border: 1.5px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        padding: 13px 18px;
        font-size: 14px;
        color: #ffffff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-input::placeholder { color: rgba(197,198,199,0.3); }
    .form-input:hover { border-color: rgba(255,255,255,0.18); }
    .form-input:focus {
        border-color: rgba(102,252,241,0.5);
        box-shadow: 0 0 0 3px rgba(102,252,241,0.08);
    }
    textarea.form-input { resize: none; line-height: 1.6; }

    /* ── Two-col grid ── */
    .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    @media (max-width: 640px) { .field-grid { grid-template-columns: 1fr; } }

    /* ── Password eye toggle ── */
    .pw-wrap { position: relative; }
    .pw-wrap .form-input { padding-right: 48px; }
    .pw-eye {
        position: absolute;
        right: 16px; top: 50%; transform: translateY(-50%);
        background: none; border: none; padding: 0; cursor: pointer;
        color: rgba(197,198,199,0.3);
        font-size: 16px; line-height: 1;
        transition: color 0.2s;
    }
    .pw-eye:hover { color: #66FCF1; }

    /* ── Buttons ── */
    .btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 24px;
        border-radius: 12px;
        font-size: 14px; font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none; cursor: pointer;
        transition: transform 0.15s, box-shadow 0.2s, opacity 0.2s;
    }
    .btn-primary:hover:not(:disabled) { transform: translateY(-1px); }
    .btn-primary:active:not(:disabled) { transform: translateY(0); }
    .btn-primary:disabled { opacity: 0.7; cursor: not-allowed; }

    .btn-teal {
        background: linear-gradient(135deg, #45A29E, #66FCF1);
        color: #0B0C10;
        width: 100%;
        justify-content: center;
    }
    .btn-teal:hover:not(:disabled) { box-shadow: 0 0 28px rgba(102,252,241,0.35); }

    .btn-amber {
        background: linear-gradient(135deg, #c07a0c, #FF9F43);
        color: #0B0C10;
        width: 100%;
        justify-content: center;
    }
    .btn-amber:hover:not(:disabled) { box-shadow: 0 0 28px rgba(255,159,67,0.35); }

    .btn-ghost {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 14px; font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: rgba(255,255,255,0.05);
        border: 1.5px solid rgba(255,255,255,0.12);
        color: #C5C6C7; cursor: pointer;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        width: 100%;
    }
    .btn-ghost:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.2); }

    /* ── Strength bar ── */
    .strength-bar { height: 3px; border-radius: 99px; width: 0; transition: width 0.35s, background 0.35s; }

    /* ── Avatar ring ── */
    .avatar-box {
        width: 100px; height: 100px;
        border-radius: 24px;
        background: linear-gradient(135deg, #4dc3ff, #45A29E);
        display: flex; align-items: center; justify-content: center;
        font-size: 36px; font-weight: 900; color: #0B0C10;
        box-shadow: 0 0 0 4px #0B0C10, 0 8px 32px rgba(0,0,0,0.5);
        position: relative; cursor: pointer; flex-shrink: 0;
        margin: -50px auto 16px auto;
        border: 2px solid rgba(102,252,241,0.3);
    }
    .avatar-overlay {
        position: absolute; inset: 0; border-radius: 20px;
        background: rgba(0,0,0,0.65);
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px;
        opacity: 0; transition: opacity 0.2s;
    }
    .avatar-box:hover .avatar-overlay { opacity: 1; }

    /* Spinner */
    @keyframes _spin { to { transform: rotate(360deg); } }
    ._spin { display: inline-block; animation: _spin 0.6s linear infinite; }
</style>

<div class="profile-wrap animate-fade-in mb-8">

    {{-- ── Page Header ── --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <a href="/admin/dashboard" style="
                width:48px; height:48px; border-radius:14px;
                background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);
                display:flex; align-items:center; justify-content:center;
                color:#C5C6C7; text-decoration:none; flex-shrink:0;
                transition: background 0.2s, color 0.2s, border-color 0.2s;
            "
            onmouseenter="this.style.background='rgba(102,252,241,0.08)';this.style.color='#66FCF1';this.style.borderColor='rgba(102,252,241,0.2)'"
            onmouseleave="this.style.background='rgba(255,255,255,0.03)';this.style.color='#C5C6C7';this.style.borderColor='rgba(255,255,255,0.06)'">
                <i class="bi bi-arrow-left" style="font-size:18px;"></i>
            </a>
            <div>
                <h2 style="color:#fff; font-size:26px; font-weight:800; margin:0; line-height:1.2; font-family:'Plus Jakarta Sans',sans-serif;">Profile Center</h2>
                <p style="color:#C5C6C7; font-size:13px; font-weight:500; margin:4px 0 0; opacity:0.6; font-family:'Plus Jakarta Sans',sans-serif;">Configure your master administration account</p>
            </div>
        </div>
        
        <div style="display:flex; align-items:center; gap:12px; padding:8px 16px; border-radius:12px; background:rgba(52,211,153,0.05); border:1px solid rgba(52,211,153,0.15);">
            <div style="width:8px; height:8px; border-radius:50%; background:#4ade80; box-shadow:0 0 10px rgba(52,211,153,0.8);"></div>
            <span style="color:#4ade80; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em; font-family:'Plus Jakarta Sans',sans-serif;">Systems Nominal</span>
        </div>
    </div>

    {{-- ── Main Layout Grid ── --}}
    <div class="profile-grid">
        
        {{-- LEFT COLUMN: Identity & Quick Stats --}}
        <div style="display:flex; flex-direction:column; gap:24px;">
            
            {{-- Identity Card --}}
            <div class="pcard identity-card">
                <div class="identity-cover">
                    <div class="identity-orb-top"></div>
                    <div class="identity-orb-bot"></div>
                </div>
                
                <div style="padding:0 24px 24px 24px; text-align:center;">
                    <label for="avatarInput" class="avatar-box">
                        A
                        <div class="avatar-overlay">
                            <i class="bi bi-camera" style="color:white; font-size:18px;"></i>
                            <span style="color:white; font-size:9px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase;">Upload</span>
                        </div>
                        <input id="avatarInput" type="file" accept="image/*" style="display:none;">
                    </label>

                    <h3 style="color:#fff; font-size:20px; font-weight:800; margin:0 0 4px; font-family:'Plus Jakarta Sans',sans-serif;">System Admin</h3>
                    <p style="color:#45A29E; font-size:13px; font-weight:500; margin:0 0 20px; font-family:'Plus Jakarta Sans',sans-serif;">Level 4 Overseer</p>
                    
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; padding-top:20px; border-top:1px dashed rgba(255,255,255,0.08);">
                        <div>
                            <p style="color:#fff; font-size:20px; font-weight:900; margin:0; line-height:1; font-family:'Plus Jakarta Sans',sans-serif;">247</p>
                            <p style="color:rgba(197,198,199,0.5); font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; margin:6px 0 0; font-family:'Plus Jakarta Sans',sans-serif;">Actions</p>
                        </div>
                        <div>
                            <p style="color:#66FCF1; font-size:20px; font-weight:900; margin:0; line-height:1; font-family:'Plus Jakarta Sans',sans-serif;">99%</p>
                            <p style="color:rgba(197,198,199,0.5); font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; margin:6px 0 0; font-family:'Plus Jakarta Sans',sans-serif;">Uptime</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger Zone Warning (moved to sidebar for better balance) --}}
            <div style="padding:20px; border-radius:20px; border:1px solid rgba(239,68,68,0.15); background:rgba(239,68,68,0.03);">
                <div style="display:flex; justify-content:center; margin-bottom:12px;">
                    <div class="sec-badge" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);">
                        <i class="bi bi-shield-x" style="color:#f87171;"></i>
                    </div>
                </div>
                <h4 style="color:#fff; font-size:14px; font-weight:700; text-align:center; margin:0 0 4px; font-family:'Plus Jakarta Sans',sans-serif;">Danger Zone</h4>
                <p style="color:rgba(248,113,113,0.6); font-size:11px; text-align:center; margin:0 0 16px; font-family:'Plus Jakarta Sans',sans-serif;">Permanently delete this account and all associated operational data. Irreversible.</p>
                <button type="button" class="btn-ghost" style="color:#f87171; border-color:rgba(239,68,68,0.3); background:transparent;"
                        onmouseenter="this.style.background='rgba(239,68,68,0.1)'" onmouseleave="this.style.background='transparent'">
                    <i class="bi bi-trash3"></i> Delete Account
                </button>
            </div>
            
        </div>

        {{-- RIGHT COLUMN: Forms --}}
        <div style="display:flex; flex-direction:column; gap:24px;">
            
            {{-- Personal Details --}}
            <div class="pcard" style="padding: 28px;">
                <div style="display:flex; align-items:center; gap:14px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.06); margin-bottom:24px;">
                    <div class="sec-badge" style="background:rgba(102,252,241,0.1); border:1px solid rgba(102,252,241,0.2);">
                        <i class="bi bi-person-lines-fill" style="color:#66FCF1;"></i>
                    </div>
                    <div>
                        <h4 style="color:#fff; font-size:16px; font-weight:800; margin:0; font-family:'Plus Jakarta Sans',sans-serif; line-height:1.2;">Basic Information</h4>
                        <p style="color:#45A29E; font-size:11px; margin:4px 0 0; opacity:0.7; font-family:'Plus Jakarta Sans',sans-serif;">Update your credentials</p>
                    </div>
                </div>

                <form id="profileForm">
                    <div style="margin-bottom:20px;">
                        <label class="form-label">Full Name</label>
                        <input class="form-input" type="text" value="System Admin" placeholder="Enter full name">
                    </div>

                    <div style="margin-bottom:28px;">
                        <label class="form-label">Email Address</label>
                        <input class="form-input" type="email" value="admin@courierpro.com" placeholder="Email address">
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <button type="button" class="btn-ghost" onclick="document.getElementById('profileForm').reset()">Discard</button>
                        <button type="submit" class="btn-primary btn-teal" id="saveProfileBtn">
                            <i class="bi bi-check2-circle" id="saveProfileIcon"></i>
                            <span id="saveProfileText">Update Data</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Security --}}
            <div class="pcard" style="padding: 28px;">
                <div style="display:flex; align-items:center; gap:14px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.06); margin-bottom:24px;">
                    <div class="sec-badge" style="background:rgba(255,159,67,0.1); border:1px solid rgba(255,159,67,0.2);">
                        <i class="bi bi-shield-lock-fill" style="color:#FF9F43;"></i>
                    </div>
                    <div>
                        <h4 style="color:#fff; font-size:16px; font-weight:800; margin:0; font-family:'Plus Jakarta Sans',sans-serif; line-height:1.2;">Security Controls</h4>
                        <p style="color:#45A29E; font-size:11px; margin:4px 0 0; opacity:0.7; font-family:'Plus Jakarta Sans',sans-serif;">Manage operational access</p>
                    </div>
                </div>

                <form id="securityForm">
                    <div style="margin-bottom:20px;">
                        <label class="form-label">Current Password</label>
                        <div class="pw-wrap">
                            <input class="form-input" type="password" id="currentPwd" placeholder="Enter current password">
                            <button type="button" class="pw-eye" onclick="togglePwd('currentPwd',this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>

                    <div class="field-grid" style="margin-bottom:8px;">
                        <div>
                            <label class="form-label">New Password</label>
                            <div class="pw-wrap">
                                <input class="form-input" type="password" id="newPwd" placeholder="Min. 8 characters" oninput="checkStrength(this.value)">
                                <button type="button" class="pw-eye" onclick="togglePwd('newPwd',this)"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Confirm Password</label>
                            <div class="pw-wrap">
                                <input class="form-input" type="password" id="confirmPwd" placeholder="Repeat password" oninput="checkMatch()">
                                <button type="button" class="pw-eye" onclick="togglePwd('confirmPwd',this)"><i class="bi bi-eye"></i></button>
                            </div>
                            <p id="matchMsg" style="display:none; font-size:11px; font-weight:600; margin:6px 0 0; font-family:'Plus Jakarta Sans',sans-serif;"></p>
                        </div>
                    </div>

                    {{-- Strength meter --}}
                    <div id="strengthWrap" style="display:none; margin-bottom:28px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                            <span style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:rgba(197,198,199,0.4); font-family:'Plus Jakarta Sans',sans-serif;">Password Strength</span>
                            <span id="strengthLabel" style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; font-family:'Plus Jakarta Sans',sans-serif;"></span>
                        </div>
                        <div style="height:4px; width:100%; background:rgba(255,255,255,0.06); border-radius:99px; overflow:hidden;">
                            <div id="strengthBar" class="strength-bar"></div>
                        </div>
                    </div>
                    <div id="spacer" style="height:20px; display:block;"></div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <button type="button" class="btn-ghost" onclick="document.getElementById('securityForm').reset(); document.getElementById('strengthWrap').style.display='none'; document.getElementById('spacer').style.display='block';">Clear</button>
                        <button type="submit" class="btn-primary btn-amber" id="saveSecurityBtn">
                            <i class="bi bi-shield-check" id="saveSecurityIcon"></i>
                            <span id="saveSecurityText">Update Password</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    const i = btn.querySelector('i');
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    i.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
}

const SL = [
    { w: '20%', bg: '#ef4444', t: 'Too Weak', tc: '#f87171' },
    { w: '45%', bg: '#f97316', t: 'Weak',     tc: '#fb923c' },
    { w: '72%', bg: '#eab308', t: 'Fair',     tc: '#facc15' },
    { w: '100%',bg: '#22c55e', t: 'Strong',   tc: '#4ade80' },
];

function checkStrength(v) {
    const wrap = document.getElementById('strengthWrap');
    const spacer = document.getElementById('spacer');
    const bar  = document.getElementById('strengthBar');
    const lbl  = document.getElementById('strengthLabel');
    if (!v) { 
        wrap.style.display = 'none'; 
        spacer.style.display = 'block';
        return; 
    }
    wrap.style.display = 'block';
    spacer.style.display = 'none';
    let s = 0;
    if (v.length >= 8)           s++;
    if (/[A-Z]/.test(v))         s++;
    if (/[0-9]/.test(v))         s++;
    if (/[^A-Za-z0-9]/.test(v))  s++;
    const l = SL[Math.min(s, 3)];
    bar.style.width = l.w;
    bar.style.background = l.bg;
    lbl.textContent = l.t;
    lbl.style.color = l.tc;
    checkMatch();
}

function checkMatch() {
    const a   = document.getElementById('newPwd').value;
    const b   = document.getElementById('confirmPwd').value;
    const inp = document.getElementById('confirmPwd');
    const msg = document.getElementById('matchMsg');
    if (!b) { msg.style.display = 'none'; inp.style.borderColor = ''; return; }
    msg.style.display = 'block';
    if (a === b) {
        msg.textContent = '✓ Passwords match';
        msg.style.color = '#4ade80';
        inp.style.borderColor = 'rgba(34,197,94,0.45)';
    } else {
        msg.textContent = '✗ Passwords do not match';
        msg.style.color = '#f87171';
        inp.style.borderColor = 'rgba(239,68,68,0.5)';
    }
}

function setLoad(b, ic, tx, on, lbl, cls) {
    const B = document.getElementById(b);
    const I = document.getElementById(ic);
    const T = document.getElementById(tx);
    B.disabled = on;
    B.style.opacity = on ? '0.72' : '';
    I.className = on ? 'bi bi-arrow-repeat _spin' : cls;
    T.textContent = on ? 'Saving…' : lbl;
}

document.getElementById('profileForm').addEventListener('submit', e => {
    e.preventDefault();
    setLoad('saveProfileBtn', 'saveProfileIcon', 'saveProfileText', true);
    setTimeout(() => setLoad('saveProfileBtn', 'saveProfileIcon', 'saveProfileText', false, 'Update Data', 'bi bi-check2-circle'), 2000);
});

document.getElementById('securityForm').addEventListener('submit', e => {
    e.preventDefault();
    if (document.getElementById('newPwd').value !== document.getElementById('confirmPwd').value) {
        return checkMatch();
    }
    setLoad('saveSecurityBtn', 'saveSecurityIcon', 'saveSecurityText', true);
    setTimeout(() => setLoad('saveSecurityBtn', 'saveSecurityIcon', 'saveSecurityText', false, 'Update Password', 'bi bi-shield-check'), 2000);
});
</script>
@endpush

@endsection
