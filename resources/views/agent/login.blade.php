<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agent Access — Rapid Route Premium</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-deep: #0B0C10;
            --accent-primary: #66FCF1;
            --accent-secondary: #45A29E;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-deep);
            background-image: radial-gradient(circle at 50% 50%, rgba(102, 252, 241, 0.05) 0%, transparent 70%);
        }

        .glass-auth {
            background: rgba(31, 40, 51, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(102, 252, 241, 0.1);
        }

        @keyframes pulse-subtle {
            0% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.02); }
            100% { opacity: 0.8; transform: scale(1); }
        }

        .animation-pulse-subtle {
            animation: pulse-subtle 3s ease-in-out infinite;
        }

        .shake { animation: shake 0.4s ease-in-out; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }
    </style>
</head>
<body class="antialiased overflow-hidden min-h-screen flex items-center justify-center p-6">
    
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#66FCF1]/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#45A29E]/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in" id="loginContainer">
        <div class="text-center mb-10 flex flex-col items-center gap-4">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#66FCF1] to-[#45A29E] flex items-center justify-center shadow-[0_0_30px_rgba(102,252,241,0.3)] mb-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tighter">Rapid<span class="text-[#66FCF1]">Route</span> Agent</h1>
            <p class="text-[#45A29E] text-xs font-bold uppercase tracking-[0.2em] opacity-80">Branch Logistics Portal</p>
        </div>

        <div class="glass-auth p-10 rounded-[40px] premium-shadow border border-white/5 space-y-8">
            <div class="space-y-1">
                <h2 class="text-xl font-bold text-white tracking-tight">Branch Login</h2>
                <p class="text-xs text-[#C5C6C7] opacity-60">Authorize your branch session</p>
            </div>

            <form id="agentLoginForm" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                            <i class="bi bi-person-badge text-lg"></i>
                        </div>
                        <input type="text" name="username" placeholder="Agent Username" required
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white placeholder-[#C5C6C7]/20 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/50 transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Access Key</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                            <i class="bi bi-shield-lock text-lg"></i>
                        </div>
                        <input type="password" name="password" placeholder="••••••••••••" required
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white placeholder-[#C5C6C7]/20 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/50 transition-all">
                    </div>
                </div>

                <div id="feedback" class="hidden text-center py-2 px-4 rounded-xl text-xs font-bold transition-all"></div>

                <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold py-4 rounded-2xl shadow-[0_10px_20px_-5px_rgba(102,252,241,0.3)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                    Access Portal <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="pt-6 border-t border-white/5 text-center">
                <p class="text-[10px] font-bold text-[#45A29E] opacity-60 tracking-widest uppercase">Secured Branch Access Only</p>
            </div>
        </div>
    </div>

    <!-- Feedback Overlay -->
    <div id="overlay" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md hidden transition-opacity duration-300">
        <div id="statusIcon" class="text-8xl transition-all duration-500 scale-0"></div>
    </div>

    <script>
        document.getElementById('agentLoginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const feedback = document.getElementById('feedback');
            const overlay = document.getElementById('overlay');
            const statusIcon = document.getElementById('statusIcon');
            const container = document.getElementById('loginContainer');
            
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Authenticating...';
            feedback.classList.add('hidden');

            try {
                const response = await fetch('/agent/login_submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        username: this.username.value,
                        password: this.password.value
                    })
                });

                const data = await response.json();

                if (data.success) {
                    overlay.classList.remove('hidden');
                    overlay.classList.add('opacity-100');
                    statusIcon.innerHTML = '<i class="bi bi-check-circle-fill text-[#66FCF1] drop-shadow-[0_0_30px_rgba(102,252,241,1)]"></i>';
                    setTimeout(() => statusIcon.classList.remove('scale-0'), 50);
                    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = 'Access Portal <i class="bi bi-arrow-right"></i>';
                    feedback.innerHTML = data.message;
                    feedback.className = 'text-center py-2 px-4 rounded-xl text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/20';
                    feedback.classList.remove('hidden');
                    container.classList.add('shake');
                    setTimeout(() => container.classList.remove('shake'), 400);
                }
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = 'Access Portal <i class="bi bi-arrow-right"></i>';
                feedback.innerHTML = "Connection Error. Failed to reach terminal.";
                feedback.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
