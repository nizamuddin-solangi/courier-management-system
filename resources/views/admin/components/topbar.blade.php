<header class="relative z-50 flex items-center justify-between p-6 glass-panel rounded-2xl premium-shadow border border-white/5">
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

        <!-- Profile Section with Dropdown -->
        <div class="relative" id="profileDropdownContainer">
            <button id="profileDropdownBtn" onclick="toggleProfileDropdown()" class="flex items-center gap-3 p-1 pr-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#4dc3ff] to-[#45A29E] flex items-center justify-center text-[#0B0C10] font-bold shadow-sm">
                    A
                </div>
                <div class="hidden md:flex flex-col items-start leading-none gap-1">
                    <span class="text-xs font-bold text-white">System Admin</span>
                    <span class="text-[10px] text-[#45A29E] font-medium uppercase tracking-tighter">Level 4 Access</span>
                </div>
                <i class="bi bi-chevron-down text-xs text-[#C5C6C7] opacity-50 transition-transform duration-200" id="profileChevron"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-64 glass-panel rounded-2xl border border-white/10 premium-shadow overflow-hidden z-50 animate-fade-in" style="animation-duration: 0.15s;">
                <!-- User Info Header -->
                <div class="px-5 py-4 border-b border-white/5 bg-white/[0.02]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4dc3ff] to-[#45A29E] flex items-center justify-center text-[#0B0C10] font-bold text-lg shadow-lg">
                            A
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">System Admin</p>
                            <p class="text-[11px] text-[#45A29E] font-medium">admin@courierpro.com</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="py-2 px-2">
                    <a href="/admin/profile" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-[#C5C6C7] hover:text-white hover:bg-[#66FCF1]/10 transition-all group">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 group-hover:bg-[#66FCF1]/15 transition-all">
                            <i class="bi bi-person-gear text-[#66FCF1] text-base"></i>
                        </div>
                        <div>
                            <span class="block">Update Profile</span>
                            <span class="block text-[10px] text-[#45A29E] opacity-70">Manage your account details</span>
                        </div>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-[#C5C6C7] hover:text-white hover:bg-[#66FCF1]/10 transition-all group">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 group-hover:bg-[#66FCF1]/15 transition-all">
                            <i class="bi bi-shield-lock text-[#66FCF1] text-base"></i>
                        </div>
                        <div>
                            <span class="block">Security</span>
                            <span class="block text-[10px] text-[#45A29E] opacity-70">Password & authentication</span>
                        </div>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-[#C5C6C7] hover:text-white hover:bg-[#66FCF1]/10 transition-all group">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 group-hover:bg-[#66FCF1]/15 transition-all">
                            <i class="bi bi-palette text-[#66FCF1] text-base"></i>
                        </div>
                        <div>
                            <span class="block">Preferences</span>
                            <span class="block text-[10px] text-[#45A29E] opacity-70">Themes & display settings</span>
                        </div>
                    </a>
                </div>

                <!-- Logout -->
                <div class="px-2 pb-2 pt-1 border-t border-white/5">
                    <a href="/admin/login" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all group">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 group-hover:bg-red-500/15 transition-all">
                            <i class="bi bi-box-arrow-right text-red-400 text-base"></i>
                        </div>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const chevron = document.getElementById('profileChevron');
        dropdown.classList.toggle('hidden');
        chevron.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('profileDropdownContainer');
        if (container && !container.contains(e.target)) {
            const dropdown = document.getElementById('profileDropdown');
            const chevron = document.getElementById('profileChevron');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                chevron.style.transform = 'rotate(0deg)';
            }
        }
    });
</script>
