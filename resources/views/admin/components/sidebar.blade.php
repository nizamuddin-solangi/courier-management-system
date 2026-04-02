<aside id="sidebar" class="w-64 bg-[#1F2833] sidebar-transition border-r border-white/5 h-screen overflow-hidden flex flex-col z-50">
    <div class="p-6 flex items-center gap-4">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="height: 3.5rem; width: auto; display: block;" class="object-contain transform hover:scale-105 transition-transform duration-300">
        <div class="flex flex-col">
            <span class="text-xl font-bold tracking-tight text-white leading-none">Courier<span class="text-[#66FCF1]">Pro</span></span>
            <span class="text-[10px] text-[#45A29E] font-bold uppercase tracking-widest mt-1 opacity-60">Fleet Ops Console</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto no-scrollbar">
        <div class="text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Main Operations</div>
        
        <x-nav-link href="/admin/dashboard" icon="bi-grid-1x2" label="Dashboard" :active="request()->is('admin/dashboard')" />
        @php
            $isCourierActive = request()->is('admin/couriers') || request()->is('admin/couriers/add');
        @endphp
        <div>
            <button onclick="document.getElementById('couriers-dropdown').classList.toggle('hidden'); document.getElementById('couriers-chevron').classList.toggle('rotate-180');" type="button" class="w-full flex items-center gap-4 px-4 py-2.5 text-sm font-medium rounded-xl transition-all group duration-200 {{ $isCourierActive ? 'bg-[#66FCF1]/10 text-[#66FCF1] border border-[#66FCF1]/20 shadow-[0_0_15px_-3px_rgba(102,252,241,0.2)]' : 'text-[#C5C6C7] hover:text-white hover:bg-white/5 border border-transparent hover:border-white/10' }}">
                <i class="bi bi-truck text-lg transition-transform duration-200 {{ $isCourierActive ? 'scale-110' : 'group-hover:scale-110 opacity-70 group-hover:opacity-100' }}"></i>
                <span class="flex-1 text-left">Couriers</span>
                <i id="couriers-chevron" class="bi bi-chevron-down ms-auto transition-transform duration-200 {{ $isCourierActive ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="couriers-dropdown" class="mt-2 space-y-1.5 pl-4 ml-6 border-l border-white/10 bg-[#0B0C10]/30 rounded-r-xl {{ $isCourierActive ? '' : 'hidden' }}">
                <a href="/admin/add_new_courier" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/add_new_courier') ? 'text-[#66FCF1] bg-[#66FCF1]/10 shadow-[0_0_10px_-3px_rgba(102,252,241,0.1)]' : 'text-[#C5C6C7] hover:text-white hover:bg-white/5' }}">
                    <i class="bi bi-plus-circle text-[16px] opacity-80"></i> 
                    <span class="flex-1 text-left">Add New Courier</span>
                </a>
                <a href="/admin/couriers" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/couriers') ? 'text-[#66FCF1] bg-[#66FCF1]/10 shadow-[0_0_10px_-3px_rgba(102,252,241,0.1)]' : 'text-[#C5C6C7] hover:text-white hover:bg-white/5' }}">
                    <i class="bi bi-list-ul text-[16px] opacity-80"></i> 
                    <span class="flex-1 text-left">Show All Courier</span>
                </a>
            </div>
        </div>
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Management</div>
        
        @php
            $isAgentActive = request()->is('admin/show_agent') || request()->is('admin/add_new_agent');
        @endphp
        <div>
            <button onclick="document.getElementById('agents-dropdown').classList.toggle('hidden'); document.getElementById('agents-chevron').classList.toggle('rotate-180');" type="button" class="w-full flex items-center gap-4 px-4 py-2.5 text-sm font-medium rounded-xl transition-all group duration-200 {{ $isAgentActive ? 'bg-[#66FCF1]/10 text-[#66FCF1] border border-[#66FCF1]/20 shadow-[0_0_15px_-3px_rgba(102,252,241,0.2)]' : 'text-[#C5C6C7] hover:text-white hover:bg-white/5 border border-transparent hover:border-white/10' }}">
                <i class="bi bi-people text-lg transition-transform duration-200 {{ $isAgentActive ? 'scale-110' : 'group-hover:scale-110 opacity-70 group-hover:opacity-100' }}"></i>
                <span class="flex-1 text-left">Fleet Agents</span>
                <i id="agents-chevron" class="bi bi-chevron-down ms-auto transition-transform duration-200 {{ $isAgentActive ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="agents-dropdown" class="mt-2 space-y-1.5 pl-4 ml-6 border-l border-white/10 bg-[#0B0C10]/30 rounded-r-xl {{ $isAgentActive ? '' : 'hidden' }}">
                <a href="/admin/add_new_agent" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/add_new_agent') ? 'text-[#66FCF1] bg-[#66FCF1]/10 shadow-[0_0_10px_-3px_rgba(102,252,241,0.1)]' : 'text-[#C5C6C7] hover:text-white hover:bg-white/5' }}">
                    <i class="bi bi-plus-circle text-[16px] opacity-80"></i> 
                    <span class="flex-1 text-left">Create New Agent</span>
                </a>
                <a href="/admin/show_agent" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/show_agent') ? 'text-[#66FCF1] bg-[#66FCF1]/10 shadow-[0_0_10px_-3px_rgba(102,252,241,0.1)]' : 'text-[#C5C6C7] hover:text-white hover:bg-white/5' }}">
                    <i class="bi bi-list-ul text-[16px] opacity-80"></i> 
                    <span class="flex-1 text-left">Show All Agents</span>
                </a>
            </div>
        </div>
        <x-nav-link href="/admin/customers" icon="bi-person-vcard" label="Customers" :active="request()->is('admin/customers')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Global Reach</div>
        
        <x-nav-link href="/admin/sms" icon="bi-chat-dots" label="SMS Portal" :active="request()->is('admin/sms')" />
        <x-nav-link href="/admin/status" icon="bi-pie-chart" label="Fleet Distribution" :active="request()->is('admin/status')" />
        <x-nav-link href="/admin/reports" icon="bi-bar-chart-line" label="Reporting" :active="request()->is('admin/reports')" />
    </nav>

    <div class="p-4 border-t border-white/5">
        <a href="{{ route('admin.logout') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-400 hover:bg-red-500/10 rounded-xl transition-all group">
            <i class="bi bi-box-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
            <span>Log Out</span>
        </a>
    </div>
</aside>
