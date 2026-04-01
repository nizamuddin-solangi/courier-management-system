@extends('admin.layouts.admin')

@section('title', 'Shipment Registry')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Table Toolbar -->
    <div class="flex flex-col md:flex-row gap-8 items-center justify-between glass-panel p-8 rounded-3xl border border-white/5 premium-shadow">
        <div class="flex flex-col gap-2 w-full md:w-auto">
            <h3 class="text-2xl font-bold text-white tracking-tight">Global Shipment Ledger</h3>
            <p class="text-xs text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Real-time Logistics Oversight</p>
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
                    <tr class="text-xs uppercase tracking-widest text-[#45A29E] font-bold opacity-60 bg-white/[0.02]">
                        <th class="px-8 py-5 border-b border-white/5">Tracking & Date</th>
                        <th class="px-8 py-5 border-b border-white/5">Sender</th>
                        <th class="px-8 py-5 border-b border-white/5">Receiver</th>
                        <th class="px-8 py-5 border-b border-white/5">Route</th>
                        <th class="px-8 py-5 border-b border-white/5">Logistics</th>
                        <th class="px-8 py-5 border-b border-white/5">Price</th>
                        <th class="px-8 py-5 border-b border-white/5">Status</th>
                        <th class="px-8 py-5 border-b border-white/5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($couriers as $ship)
                    @php
                        $statusColor = match($ship->status) {
                            'pending' => '#FF9F43',
                            'in_transit' => '#66FCF1',
                            'delivered' => '#45A29E',
                            'cancelled' => '#FF4B5C',
                            default => '#C5C6C7'
                        };
                    @endphp
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-white tracking-widest group-hover:text-[#66FCF1] transition-colors">{{ $ship->tracking_number }}</span>
                                <span class="text-[10px] text-[#45A29E] font-bold uppercase tracking-tighter opacity-70">{{ $ship->created_at ? $ship->created_at->format('d M Y') : 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-[#C5C6C7]">{{ $ship->sender_name }}</span>
                                <span class="text-xs text-[#45A29E] opacity-70">{{ $ship->sender_phone }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-[#C5C6C7]">{{ $ship->receiver_name }}</span>
                                <span class="text-xs text-[#45A29E] opacity-70">{{ $ship->receiver_phone }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col items-start gap-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-[#C5C6C7] opacity-60">{{ $ship->from_city }}</span>
                                    <i class="bi bi-arrow-right text-[10px] text-[#66FCF1]"></i>
                                    <span class="text-xs font-bold text-[#66FCF1]">{{ $ship->to_city }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-[#C5C6C7] uppercase">{{ $ship->parcel_type }}</span>
                                <span class="text-xs text-[#45A29E] font-bold opacity-70">{{ $ship->weight }} KG</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-[#66FCF1]">Rs. {{ number_format($ship->price, 2) }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold border" style="background-color: {{ $statusColor }}10; color: {{ $statusColor }}; border-color: {{ $statusColor }}30">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $statusColor }}"></span>
                                {{ strtoupper(str_replace('_', ' ', $ship->status)) }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-1">
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-[#66FCF1]/10 hover:text-[#66FCF1] transition-all border border-transparent hover:border-[#66FCF1]/20 text-sm" title="Scan Data"><i class="bi bi-qr-code"></i></button>
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-blue-500/10 hover:text-blue-400 transition-all border border-transparent hover:border-blue-500/20 text-sm" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-red-500/10 hover:text-red-400 transition-all border border-transparent hover:border-red-500/20 text-sm" title="Delete"><i class="bi bi-trash3"></i></button>
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

<!-- Edit Shipment Modal -->
<x-modal id="editShipmentModal" title="Update Route Manifest">
    <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Consignee Intelligence</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" value="Global Logistics Inc." required>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Tracking Index</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white/50 focus:outline-none" value="CP-X-9921" disabled>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Current Node</label>
                <select class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none">
                    <option selected>Hub A (Origin)</option>
                    <option>Regional Hub Beta</option>
                    <option>Distribution Node Zeta</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Operational Status</label>
                <select class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-[#66FCF1] focus:outline-none font-bold">
                    <option selected>In-Transit</option>
                    <option>Delivered</option>
                    <option>Pending</option>
                    <option>On-Hold</option>
                </select>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Logistics Directives</label>
            <textarea class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white h-24 focus:outline-none" placeholder="Enter updated directives...">Priority express handling requested for Downtown DC node.</textarea>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="button" onclick="closeModal('editShipmentModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-3 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Update</button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-400 text-[#0B0C10] font-bold py-3 rounded-2xl shadow-lg hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] transition-all">Execute Update</button>
        </div>
    </form>
</x-modal>

<!-- Delete Shipment Modal -->
<x-modal id="deleteShipmentModal" title="Confirm Decommission">
    <div class="space-y-8 text-center">
        <div class="w-20 h-20 rounded-full bg-red-500/10 flex items-center justify-center mx-auto border border-red-500/20 text-red-500 text-3xl">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        
        <div class="space-y-2">
            <h4 class="text-xl font-bold text-white">Decommission Shipment?</h4>
            <p class="text-sm text-[#C5C6C7] opacity-70 px-4">This action will permanently purge the manifest record for <span class="text-white font-bold tracking-widest">CP-X-9921</span> from the global ledger.</p>
        </div>

        <div class="flex gap-4">
            <button type="button" onclick="closeModal('deleteShipmentModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Action</button>
            <button type="button" onclick="closeModal('deleteShipmentModal')" class="flex-1 bg-red-500/80 hover:bg-red-500 text-white font-bold py-4 rounded-2xl shadow-[0_10px_20px_-5px_rgba(239,68,68,0.3)] transition-all">Confirm Purge</button>
        </div>
    </div>
</x-modal>
@endsection
