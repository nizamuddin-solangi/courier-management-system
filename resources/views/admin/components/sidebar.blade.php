<aside id="sidebar" class="w-64 glass-panel sidebar-transition border-r h-screen overflow-hidden flex flex-col z-50">
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
        <x-nav-link href="/admin/couriers" icon="bi-truck" label="Shipments" :active="request()->is('admin/couriers')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Management</div>
        
        <x-nav-link href="/admin/agents" icon="bi-people" label="Fleet Agents" :active="request()->is('admin/agents')" />
        <x-nav-link href="/admin/customers" icon="bi-person-vcard" label="Customers" :active="request()->is('admin/customers')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Global Reach</div>
        
        <x-nav-link href="/admin/sms" icon="bi-chat-dots" label="SMS Portal" :active="request()->is('admin/sms')" />
        <x-nav-link href="/admin/status" icon="bi-pie-chart" label="Fleet Distribution" :active="request()->is('admin/status')" />
        <x-nav-link href="/admin/reports" icon="bi-bar-chart-line" label="Analytics" :active="request()->is('admin/reports')" />
    </nav>

    <div class="p-4 border-t border-white/5">
        <a href="/admin/login" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-400 hover:bg-red-500/10 rounded-xl transition-all group">
            <i class="bi bi-box-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
            <span>Log Out</span>
        </a>
    </div>
</aside>
