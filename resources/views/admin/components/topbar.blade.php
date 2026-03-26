<header class="flex items-center justify-between p-6 glass-panel rounded-2xl premium-shadow border border-white/5">
    <div class="flex items-center gap-6">
        <div class="hidden md:flex flex-col">
            <h1 class="text-2xl font-bold text-white tracking-tight">@yield('title', 'Dashboard')</h1>
            <p class="text-xs text-[#45A29E] font-medium tracking-wide">Welcome back to the Fleet Console 👋</p>
        </div>
        
        <!-- Global Search -->
        <div class="relative group hidden lg:block">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/40 transition-colors group-focus-within:text-[#66FCF1]">
                <i class="bi bi-search text-lg"></i>
            </div>
            <input type="text" 
                class="w-80 bg-black/20 border border-white/10 rounded-xl py-2.5 pl-12 pr-4 text-sm text-white placeholder-[#C5C6C7]/50 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/50 focus:border-[#66FCF1]/50 transition-all"
                placeholder="Scan shipments, agents, IDs...">
        </div>
    </div>

    <div class="flex items-center gap-4">
        <!-- Quick Actions -->
        <div class="flex items-center gap-2 p-1 bg-white/5 rounded-xl border border-white/5 h-11">
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-[#C5C6C7] hover:text-[#66FCF1] hover:bg-[#66FCF1]/10 transition-all relative">
                <i class="bi bi-bell text-xl"></i>
                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,1)]"></span>
            </button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-[#C5C6C7] hover:text-[#66FCF1] hover:bg-[#66FCF1]/10 transition-all">
                <i class="bi bi-gear text-xl"></i>
            </button>
        </div>

        <div class="h-10 w-[1px] bg-white/10 mx-2"></div>

        <!-- Profile Section -->
        <button class="flex items-center gap-3 p-1 pr-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#4dc3ff] to-[#45A29E] flex items-center justify-center text-[#0B0C10] font-bold shadow-sm">
                A
            </div>
            <div class="hidden md:flex flex-col items-start leading-none gap-1">
                <span class="text-xs font-bold text-white">System Admin</span>
                <span class="text-[10px] text-[#45A29E] font-medium uppercase tracking-tighter">Level 4 Access</span>
            </div>
            <i class="bi bi-chevron-down text-xs text-[#C5C6C7] opacity-50"></i>
        </button>
    </div>
</header>
