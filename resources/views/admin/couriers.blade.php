@extends('admin.layouts.admin')

@section('title', 'Shipment Registry')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Table Toolbar -->
    <div class="flex flex-col md:flex-row gap-6 items-center justify-between glass-panel p-6 rounded-3xl border border-white/5 premium-shadow">
        <div class="flex flex-col gap-1 w-full md:w-auto">
            <h3 class="text-xl font-bold text-white tracking-tight">Global Shipment Ledger</h3>
            <p class="text-[10px] text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Real-time Logistics Oversight</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
            <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                    <i class="bi bi-search text-sm"></i>
                </div>
                <input type="text" class="w-full bg-black/20 border border-white/10 rounded-xl py-2.5 pl-11 pr-4 text-sm text-white placeholder-[#C5C6C7]/30 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all" placeholder="Track ID, Consignee, or Address...">
            </div>

            <button onclick="openModal('newShipmentModal')" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold px-6 py-2.5 rounded-xl shadow-[0_10px_20px_-5px_rgba(102,252,241,0.2)] hover:shadow-[0_15px_30px_-5px_rgba(102,252,241,0.4)] transition-all">
                <i class="bi bi-box-seam"></i>
                <span>Manifest New Shipment</span>
            </button>
        </div>
    </div>

    <!-- SHIPMENT TABLE -->
    <div class="glass-panel overflow-hidden rounded-[40px] border border-white/5 premium-shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="text-[10px] uppercase tracking-widest text-[#45A29E] font-bold opacity-60 bg-white/[0.02]">
                        <th class="px-8 py-6 border-b border-white/5">Tracking Index</th>
                        <th class="px-8 py-6 border-b border-white/5">Consignee Intelligence</th>
                        <th class="px-8 py-6 border-b border-white/5">Route Manifest</th>
                        <th class="px-8 py-6 border-b border-white/5">Current State</th>
                        <th class="px-8 py-6 border-b border-white/5 text-center">Protocol Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @php
                        $couriers = [
                            ['id' => 'CP-X-9921', 'name' => 'Global Logistics Inc.', 'contact' => 'Mark Stevenson', 'phone' => '+1 (555) 012-4432', 'origin' => 'Hub A', 'dest' => 'Downtown DC', 'status' => 'In-Transit', 'color' => '#66FCF1'],
                            ['id' => 'CP-X-9922', 'name' => 'Sarah J. Miller', 'contact' => 'Individual', 'phone' => '+1 (555) 012-7721', 'origin' => 'Hub B', 'dest' => 'Sector 7 Res', 'status' => 'Delivered', 'color' => '#45A29E'],
                            ['id' => 'CP-X-9923', 'name' => 'Techno-Systems GMBH', 'contact' => 'Warehouse Lead', 'phone' => '+1 (555) 012-9844', 'origin' => 'Factory 1', 'dest' => 'Central Hub', 'status' => 'Pending', 'color' => '#FF9F43'],
                            ['id' => 'CP-X-9924', 'name' => 'Apex Corp Industries', 'contact' => 'Ops Manager', 'phone' => '+1 (555) 012-1100', 'origin' => 'Hub A', 'dest' => 'Tech Park', 'status' => 'On-Hold', 'color' => '#FF4B5C'],
                        ];
                    @endphp

                    @foreach($couriers as $ship)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-white tracking-widest group-hover:text-[#66FCF1] transition-colors">{{ $ship['id'] }}</span>
                                <span class="text-[9px] text-[#45A29E] font-bold uppercase tracking-tighter opacity-70">Express Priority</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-[#C5C6C7]">{{ $ship['name'] }}</span>
                                <span class="text-[10px] text-[#45A29E] opacity-60">{{ $ship['contact'] }} • {{ $ship['phone'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-bold text-[#C5C6C7] opacity-50">{{ $ship['origin'] }}</span>
                                <div class="flex-1 h-[1px] w-12 bg-white/10 relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#66FCF1]/30 to-transparent animate-pulse"></div>
                                    <i class="bi bi-chevron-right absolute -right-1.5 -top-1.5 text-[8px] text-[#66FCF1]"></i>
                                </div>
                                <span class="text-[10px] font-bold text-[#66FCF1]">{{ $ship['dest'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold border" style="background-color: {{ $ship['color'] }}10; color: {{ $ship['color'] }}; border-color: {{ $ship['color'] }}30">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $ship['color'] }}"></span>
                                {{ $ship['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-2">
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-[#66FCF1]/10 hover:text-[#66FCF1] transition-all border border-transparent hover:border-[#66FCF1]/20" title="Scan Data"><i class="bi bi-qr-code"></i></button>
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-blue-500/10 hover:text-blue-400 transition-all border border-transparent hover:border-blue-500/20" title="Update Route"><i class="bi bi-pencil-square"></i></button>
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-white/10 hover:text-white transition-all" title="More Options"><i class="bi bi-three-dots"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- New Shipment Modal -->
<x-modal id="newShipmentModal" title="Generate Manifest">
    <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Consignee Full Name</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" placeholder="Target entity..." required>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Tracking Serial</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" value="CP-X-{{ rand(1000, 9999) }}" disabled>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Origin Node</label>
                <select class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-[#C5C6C7] focus:outline-none">
                    <option>Global Hub Alpha</option>
                    <option>Regional Hub Beta</option>
                    <option>Distribution Node Zeta</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Target Destination</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white" placeholder="Destination address..." required>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Special Handling / Metadata</label>
            <textarea class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white h-24 focus:outline-none" placeholder="Enter fragile, priority, or other directives..."></textarea>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="button" onclick="closeModal('newShipmentModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-3 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Manifest</button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold py-3 rounded-2xl shadow-lg hover:shadow-[0_0_20px_rgba(102,252,241,0.3)] transition-all">Execute Dispatch</button>
        </div>
    </form>
</x-modal>
@endsection
