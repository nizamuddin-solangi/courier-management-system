@extends('admin.layouts.admin')

@section('title', 'Client Registry')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Table Toolbar -->
    <div class="flex flex-col md:flex-row gap-8 items-center justify-between glass-panel p-8 rounded-3xl border border-white/5 premium-shadow">
        <div class="flex flex-col gap-2 w-full md:w-auto">
            <h3 class="text-2xl font-bold text-white tracking-tight">Active Client Nodes</h3>
            <p class="text-xs text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Customer Intelligence & Relationship Hub</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
            <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                    <i class="bi bi-person-search text-sm"></i>
                </div>
                <input type="text" class="w-full bg-black/20 border border-white/10 rounded-xl py-2.5 pl-11 pr-4 text-sm text-white placeholder-[#C5C6C7]/30 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all" placeholder="Search by name, company, or email...">
            </div>

            <button onclick="openModal('addCustomerModal')" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold px-6 py-2.5 rounded-xl shadow-[0_10px_20px_-5px_rgba(102,252,241,0.2)] hover:shadow-[0_15px_30px_-5px_rgba(102,252,241,0.4)] transition-all">
                <i class="bi bi-person-plus"></i>
                <span>Register New Entity</span>
            </button>
        </div>
    </div>

    <!-- CUSTOMERS TABLE -->
    <div class="glass-panel overflow-hidden rounded-[40px] border border-white/5 premium-shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="text-xs uppercase tracking-widest text-[#45A29E] font-bold opacity-60 bg-white/[0.02]">
                        <th class="px-8 py-5 border-b border-white/5">Entity Profile</th>
                        <th class="px-8 py-5 border-b border-white/5">Operational History</th>
                        <th class="px-8 py-5 border-b border-white/5">Node Interaction</th>
                        <th class="px-8 py-5 border-b border-white/5">Trust Status</th>
                        <th class="px-8 py-5 border-b border-white/5 text-center">Protocol Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @php
                        $customers = [
                            ['name' => 'Apex Corp Industries', 'type' => 'Corporate Entity', 'email' => 'ops@apex-corp.com', 'orders' => 154, 'last' => '2 hours ago', 'status' => 'Premium', 'color' => '#66FCF1'],
                            ['name' => 'Sarah J. Miller', 'type' => 'Individual Pro', 'email' => 'sarah.m@web.me', 'orders' => 12, 'last' => '1 day ago', 'status' => 'Verified', 'color' => '#45A29E'],
                            ['name' => 'Techno-Systems GMBH', 'type' => 'Industrial Node', 'email' => 'logistics@techno-sys.de', 'orders' => 281, 'last' => '40 mins ago', 'status' => 'Enterprise', 'color' => '#00D2FF'],
                            ['name' => 'Urban Fresh Markets', 'type' => 'Retail Chain', 'email' => 'fresh@urban-mkt.com', 'orders' => 45, 'last' => '3 days ago', 'status' => 'Standard', 'color' => '#C5C6C7'],
                        ];
                    @endphp

                    @foreach($customers as $cust)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#1F2833] to-[#0B0C10] border border-white/5 flex items-center justify-center text-xl font-bold text-white group-hover:border-[#66FCF1]/30 transition-all">
                                    {{ substr($cust['name'], 0, 1) }}
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-base font-bold text-white tracking-tight group-hover:text-[#66FCF1] transition-colors">{{ $cust['name'] }}</span>
                                    <span class="text-xs text-[#C5C6C7] opacity-60">{{ $cust['email'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-white opacity-90">{{ $cust['orders'] }} Completed Orders</span>
                                <span class="text-xs text-[#45A29E] font-bold uppercase tracking-tighter opacity-70">Last scan: {{ $cust['last'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-[#C5C6C7] opacity-80">{{ $cust['type'] }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold border" style="background-color: {{ $cust['color'] }}10; color: {{ $cust['color'] }}; border-color: {{ $cust['color'] }}30">
                                <i class="bi bi-shield-check"></i>
                                {{ $cust['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="w-10 h-10 rounded-xl flex items-center justify-center text-[#C5C6C7] hover:bg-white/10 text-lg" title="Profile Intelligence"><i class="bi bi-eye"></i></button>
                                <button onclick="openModal('editCustomerModal')" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#C5C6C7] hover:bg-[#66FCF1]/10 hover:text-[#66FCF1] transition-all border border-transparent hover:border-[#66FCF1]/20 text-lg" title="Direct Multi-Comm"><i class="bi bi-pencil-square"></i></button>
                                <button onclick="openModal('deleteCustomerModal')" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#C5C6C7] hover:bg-red-500/10 hover:text-red-400 text-lg" title="Decommission Node"><i class="bi bi-person-x"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal id="addCustomerModal" title="Entity Registration">
    <form class="space-y-6">
        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Entity Name / Legal Name</label>
            <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" placeholder="Enter name...">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Communication Channel (Email)</label>
                <input type="email" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" placeholder="client@corp.com">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Secure Phone Line</label>
                <input type="tel" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" placeholder="+1 (555) 000-0000">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Target Address Hub</label>
            <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" placeholder="Primary delivery location...">
        </div>

        <div class="flex gap-4 pt-4">
            <button type="button" onclick="closeModal('addCustomerModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-3 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Op</button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold py-3 rounded-2xl shadow-lg hover:shadow-[0_0_20px_rgba(102,252,241,0.3)] transition-all">Establish Entity</button>
        </div>
    </form>
</x-modal>

<!-- Edit Customer Modal -->
<x-modal id="editCustomerModal" title="Update Entity Profile">
    <form class="space-y-6">
        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Entity Name / Legal Name</label>
            <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" value="Apex Corp Industries">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Communication Channel</label>
                <input type="email" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" value="ops@apex-corp.com">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Secure Phone Line</label>
                <input type="tel" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" value="+1 (555) 012-9988">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Target Address Hub</label>
            <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" value="122 Industrial Way, Tech Park">
        </div>

        <div class="flex gap-4 pt-4">
            <button type="button" onclick="closeModal('editCustomerModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-3 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Update</button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-400 text-[#0B0C10] font-bold py-3 rounded-2xl shadow-lg hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] transition-all">Execute Update</button>
        </div>
    </form>
</x-modal>

<!-- Delete Customer Modal -->
<x-modal id="deleteCustomerModal" title="Decommission Entity Node">
    <div class="space-y-8 text-center">
        <div class="w-20 h-20 rounded-full bg-red-500/10 flex items-center justify-center mx-auto border border-red-500/20 text-red-500 text-3xl">
            <i class="bi bi-person-x"></i>
        </div>
        
        <div class="space-y-2">
            <h4 class="text-xl font-bold text-white">Decommission Entity?</h4>
            <p class="text-sm text-[#C5C6C7] opacity-70 px-4">This will permanently terminate the relationship profile for <span class="text-white font-bold tracking-widest">APEX CORP INDUSTRIES</span>.</p>
        </div>

        <div class="flex gap-4">
            <button type="button" onclick="closeModal('deleteCustomerModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Action</button>
            <button type="button" onclick="closeModal('deleteCustomerModal')" class="flex-1 bg-red-500/80 hover:bg-red-500 text-white font-bold py-4 rounded-2xl shadow-[0_10px_20px_-5px_rgba(239,68,68,0.3)] transition-all">Confirm Termination</button>
        </div>
    </div>
</x-modal>
@endsection
