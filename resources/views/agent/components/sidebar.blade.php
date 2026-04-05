<aside id="sidebar" class="w-64 bg-[#1F2833] sidebar-transition border-r border-white/5 h-screen overflow-hidden flex flex-col z-50">
    <div class="p-6 flex items-center gap-4">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="height: 3.5rem; width: auto; display: block;" class="object-contain transform hover:scale-105 transition-transform duration-300">
        <div class="flex flex-col">
            <span class="text-xl font-bold tracking-tight text-white leading-none">Courier<span class="text-[#64ffda]">Pro</span></span>
            <span class="text-[10px] text-[#45A29E] font-bold uppercase tracking-widest mt-1 opacity-60">Agent Console</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto no-scrollbar">
        <div class="text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Branch Operations</div>
        
        <x-nav-link href="/agent/dashboard" icon="bi-grid-1x2" label="Status Dashboard" :active="request()->is('agent/dashboard')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Shipment Handling</div>
        
        <x-nav-link href="/agent/new-courier" icon="bi-plus-circle" label="New Courier" :active="request()->is('agent/new-courier')" />
        <x-nav-link href="/agent/couriers" icon="bi-truck-flatbed" label="View Shipments" :active="request()->is('agent/couriers')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Communications</div>
        
        <x-nav-link href="/agent/sms" icon="bi-chat-quote" label="SMS Notifications" :active="request()->is('agent/sms')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">Reporting</div>
        
        <x-nav-link href="/agent/reports" icon="bi-file-earmark-bar-graph" label="Branch Reports" :active="request()->is('agent/reports')" />
        
        <div class="pt-5 text-[10px] uppercase tracking-widest text-[#45A29E] font-bold px-4 mb-2 opacity-60">My Account</div>
        <x-nav-link href="/agent/profile" icon="bi-person-gear" label="Profile Settings" :active="request()->is('agent/profile')" />
    </nav>

    <div class="p-4 border-t border-white/5">
        <a href="{{ route('agent.logout') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-400 hover:bg-red-500/10 rounded-xl transition-all group">
            <i class="bi bi-box-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
            <span>Log Out</span>
        </a>
    </div>
</aside>
