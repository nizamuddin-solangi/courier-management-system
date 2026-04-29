<header class="relative z-50 flex items-center justify-between p-6 glass-panel rounded-2xl premium-shadow border border-white/5">
    <div class="flex items-center gap-6">
        <div class="hidden md:flex flex-col">
            <h1 class="text-2xl font-bold text-white tracking-tight">@yield('title', 'Dashboard')</h1>
            <p class="text-xs text-[#45A29E] font-medium tracking-wide">Branch Management Console — {{ $current_agent->branch_name ?? 'Loading...' }}</p>
        </div>
    </div>

    <x-portal-nav />

    @if(Session::get('agent_is_demo'))
        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/20 animate-pulse">
            <i class="bi bi-box-seam text-amber-500 text-lg"></i>
            <div class="flex flex-col">
                <span class="text-[10px] font-black text-amber-500 uppercase tracking-tighter leading-none">Sandbox Mode</span>
                <span class="text-[8px] text-amber-500/70 font-bold uppercase tracking-widest leading-none mt-1">Local Node Only</span>
            </div>
        </div>
    @endif

    <div class="flex items-center gap-4">
        <!-- Notifications -->
        <div class="flex items-center gap-2 p-1 bg-white/5 rounded-xl border border-white/5 h-11">
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-[#C5C6C7] hover:text-[#64ffda] hover:bg-[#64ffda]/10 transition-all relative">
                <i class="bi bi-bell text-xl"></i>
                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,1)]"></span>
            </button>
        </div>

        <div class="h-10 w-[1px] bg-white/10 mx-2"></div>

        <!-- Profile Dropdown -->
        <div class="relative" id="agentProfileDropdownContainer">
            <button id="agentProfileDropdownBtn" onclick="toggleAgentProfileDropdown()" class="flex items-center gap-3 p-1 pr-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#64ffda] to-[#45A29E] flex items-center justify-center text-[#0B0C10] font-bold shadow-sm relative overflow-hidden">
                    @if(isset($current_agent) && $current_agent->image)
                        <img src="{{ asset('uploads/' . $current_agent->image) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($current_agent->name ?? 'A', 0, 1)) }}
                    @endif
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-emerald-500 border-2 border-[#1F2833] shadow-[0_0_10px_rgba(16,185,129,0.4)]"></span>
                </div>
                <div class="hidden md:flex flex-col items-start leading-none gap-1 text-left">
                    <span class="text-xs font-bold text-white">{{ $current_agent?->name ?? 'Agent' }}</span>
                    <span class="text-[10px] text-[#45A29E] font-medium uppercase tracking-tighter">{{ $current_agent?->agent_code ?? 'AGT-XXXX' }}</span>
                </div>
                <i class="bi bi-chevron-down text-xs text-[#C5C6C7] opacity-50 transition-transform duration-200" id="agentProfileChevron"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="agentProfileDropdown" class="hidden absolute right-0 mt-3 w-64 rounded-2xl border border-[#64ffda]/20 shadow-[0_20px_60px_rgba(0,0,0,0.8)] overflow-hidden z-50 animate-fade-in" style="background: #0B0C10 !important; animation-duration: 0.15s;">
                <div class="px-5 py-4 border-b border-white/10" style="background: rgba(255,255,255,0.05);">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#64ffda] to-[#45A29E] flex items-center justify-center text-[#0B0C10] font-bold text-lg shadow-lg overflow-hidden">
                            @if(isset($current_agent) && $current_agent->image)
                                <img src="{{ asset('uploads/' . $current_agent->image) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(($current_agent->name ?? 'A'), 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ $current_agent?->name ?? 'Agent Name' }}</p>
                            <p class="text-[11px] text-[#45A29E] font-medium">{{ $current_agent?->email ?? 'agent@rapidroute.com' }}</p>
                        </div>
                    </div>
                </div>

                <div class="py-2 px-2">
                    <a href="/agent/profile" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-[#C5C6C7] hover:text-white hover:bg-[#64ffda]/10 transition-all group">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 group-hover:bg-[#64ffda]/15 transition-all">
                            <i class="bi bi-person-gear text-[#64ffda] text-base"></i>
                        </div>
                        <div>
                            <span class="block">Update Profile</span>
                            <span class="block text-[10px] text-[#45A29E] opacity-70">Personal information</span>
                        </div>
                    </a>
                </div>

                <div class="px-2 pb-2 pt-1 border-t border-white/5">
                    <a href="/agent/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all group">
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
    function toggleAgentProfileDropdown() {
        const dropdown = document.getElementById('agentProfileDropdown');
        const chevron = document.getElementById('agentProfileChevron');
        dropdown.classList.toggle('hidden');
        if (chevron) {
            chevron.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    }

    document.addEventListener('click', function(e) {
        const container = document.getElementById('agentProfileDropdownContainer');
        if (container && !container.contains(e.target)) {
            const dropdown = document.getElementById('agentProfileDropdown');
            const chevron = document.getElementById('agentProfileChevron');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        }
    });
</script>
