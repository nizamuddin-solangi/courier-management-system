<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personnel Auth — CourierPro Premium</title>

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
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(102, 252, 241, 0.1);
        }

        .auth-glow {
            box-shadow: 0 0 50px -10px rgba(102, 252, 241, 0.1);
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased overflow-hidden min-h-screen flex items-center justify-center p-6">
    
    <!-- Decorative Background Elements -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#66FCF1]/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#45A29E]/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in">
        <!-- Brand Header -->
        <div class="text-center mb-10 flex flex-col items-center gap-4">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#66FCF1] to-[#45A29E] flex items-center justify-center shadow-[0_0_30px_rgba(102,252,241,0.3)] mb-2 floating">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tighter">Courier<span class="text-[#66FCF1]">Pro</span> Premium</h1>
            <p class="text-[#45A29E] text-xs font-bold uppercase tracking-[0.2em] opacity-80">Fleet Management System Authorization</p>
        </div>

        <!-- Auth Card -->
        <div class="glass-auth auth-glow p-10 rounded-[40px] premium-shadow border border-white/5 space-y-8">
            <div class="space-y-1">
                <h2 class="text-xl font-bold text-white tracking-tight">Personnel Access</h2>
                <p class="text-xs text-[#C5C6C7] opacity-60">Authentication required for restricted fleet domains</p>
            </div>

            <form class="space-y-6" onsubmit="event.preventDefault(); window.location.href='/admin/dashboard'">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Identifier</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                            <i class="bi bi-person text-lg"></i>
                        </div>
                        <input type="email" 
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white placeholder-[#C5C6C7]/20 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/50 focus:border-[#66FCF1]/50 transition-all"
                            placeholder="admin@courierpro.com" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center pl-1 pr-1">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Access Key</label>
                        <a href="#" class="text-[10px] font-bold text-[#66FCF1] hover:underline decoration-[#66FCF1]/30 underline-offset-4">Forgot Link?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                            <i class="bi bi-shield-lock text-lg"></i>
                        </div>
                        <input type="password" 
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white placeholder-[#C5C6C7]/20 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/50 focus:border-[#66FCF1]/50 transition-all"
                            placeholder="••••••••••••" required>
                    </div>
                </div>

                <div class="flex items-center gap-3 pl-1">
                    <input type="checkbox" id="remember" class="w-4 h-4 rounded-md bg-black/40 border-white/10 text-[#66FCF1] focus:ring-[#66FCF1]/50 transition-all">
                    <label for="remember" class="text-xs font-semibold text-[#C5C6C7] cursor-pointer">Maintain login session</label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold py-4 rounded-2xl shadow-[0_10px_20px_-5px_rgba(102,252,241,0.3)] hover:shadow-[0_15px_30px_-5px_rgba(102,252,241,0.5)] hover:-translate-y-1 transition-all duration-300">
                    Authorize Access <i class="bi bi-chevron-right ml-2 text-sm"></i>
                </button>
            </form>

            <div class="pt-6 border-t border-white/5 text-center">
                <p class="text-[10px] font-bold text-[#45A29E] opacity-60">SECURED BY FLEET-SCAN QUANTUM ENCRYPTION</p>
            </div>
        </div>
    </div>
</body>
</html>
