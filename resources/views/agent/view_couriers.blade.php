@extends('agent.layouts.agent')

@section('title', 'Shipment Inventory')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Fleet <span class="text-[#64ffda]">Inventory</span></h2>
            <p class="text-[#C5C6C7] opacity-60 mt-1">Real-time status of shipments originating from branch {{ $current_agent->branch_name }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative group">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-[#45A29E] opacity-50 group-focus-within:opacity-100 transition-opacity"></i>
                <input type="text" placeholder="Search tracking ID..." 
                    class="bg-white/5 border border-white/10 rounded-xl py-2.5 pl-11 pr-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#64ffda]/50 transition-all w-64">
            </div>
            <button class="bg-white/5 hover:bg-white/10 border border-white/10 p-2.5 rounded-xl text-[#C5C6C7] transition-all">
                <i class="bi bi-filter-right text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="glass-panel rounded-[40px] premium-shadow border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.2em] text-[#45A29E] font-black border-b border-white/5 bg-white/[0.02]">
                        <th class="px-8 py-6">Consignment</th>
                        <th class="px-6 py-6">Consignor</th>
                        <th class="px-6 py-6">Destination</th>
                        <th class="px-6 py-6">Specs</th>
                        <th class="px-6 py-6">Status</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($couriers as $shipment)
                    <tr class="group hover:bg-white/[0.02] transition-all">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-white group-hover:text-[#64ffda] transition-colors">{{ $shipment->tracking_number }}</span>
                                <span class="text-[10px] text-[#C5C6C7] opacity-40 font-mono">{{ $shipment->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-white">{{ $shipment->sender_name }}</span>
                                <span class="text-[10px] text-[#45A29E] font-medium">{{ $shipment->sender_phone }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-white">{{ $shipment->receiver_name }}</span>
                                <span class="text-[11px] text-[#C5C6C7] opacity-60">{{ $shipment->to_city }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-[#45A29E] font-black uppercase tracking-widest">{{ $shipment->parcel_type }}</span>
                                <span class="text-xs font-mono text-[#64ffda]">{{ $shipment->weight }} kg</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'in_transit' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'delivered' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'returned' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                ];
                                $class = $statusClasses[$shipment->status] ?? 'bg-white/5 text-[#C5C6C7] border-white/10';
                            @endphp
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border {{ $class }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current shadow-[0_0_8px_currentColor]"></span>
                                <span class="text-[9px] font-black uppercase tracking-widest">{{ str_replace('_', ' ', $shipment->status) }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-[#C5C6C7] hover:bg-[#64ffda]/10 hover:text-[#64ffda] transition-all">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-[#C5C6C7] hover:bg-[#64ffda]/10 hover:text-[#64ffda] transition-all">
                                    <i class="bi bi-printer"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-40">
                                <i class="bi bi-inbox text-5xl"></i>
                                <span class="text-sm font-medium">No shipments registered in branch {{ $current_agent->branch_name }} yet.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
