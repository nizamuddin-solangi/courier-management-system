@extends('agent.layouts.agent')

@section('title', 'Branch Operations Console')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto pb-10">
    
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Global Shipments', 'value' => $total_shipments, 'icon' => 'bi-box-seam', 'color' => '#64ffda', 'desc' => 'Total branch logistics'],
            ['label' => 'Active In-Transit', 'value' => $in_progress, 'icon' => 'bi-truck', 'color' => '#3b82f6', 'desc' => 'Nodes currently moving'],
            ['label' => 'Total Delivered', 'value' => $delivered, 'icon' => 'bi-check2-circle', 'color' => '#10b981', 'desc' => 'Successful end-node syncs'],
            ['label' => 'Awaiting Dispatch', 'value' => $pending, 'icon' => 'bi-clock-history', 'color' => '#f59e0b', 'desc' => 'Queued for transmission']
        ] as $stat)
        <div class="glass-panel p-8 rounded-[32px] premium-shadow border border-white/5 group hover:border-[#64ffda]/20 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:bg-[#64ffda]/10 transition-colors"></div>
            
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-transform duration-500 group-hover:scale-110 shadow-lg" 
                     style="background: {{ $stat['color'] }}10; color: {{ $stat['color'] }}; border: 1px solid {{ $stat['color'] }}20;">
                    <i class="bi {{ $stat['icon'] }}"></i>
                </div>
                <div class="flex flex-col">
                    <p class="text-[10px] font-black text-[#45A29E] uppercase tracking-[0.2em] opacity-80">{{ $stat['label'] }}</p>
                    <p class="text-[9px] text-[#C5C6C7] opacity-40 font-medium">{{ $stat['desc'] }}</p>
                </div>
            </div>
            
            <h3 class="text-4xl font-black text-white tracking-tight leading-none">{{ number_format($stat['value']) }}</h3>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Activity Feed -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="glass-panel rounded-[40px] premium-shadow border border-white/5 overflow-hidden flex flex-col h-full">
                <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.01]">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 rounded-xl bg-[#64ffda]/10 border border-[#64ffda]/20 text-[#64ffda]">
                            <i class="bi bi-activity text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white tracking-tight">Recent Node Activity</h3>
                            <p class="text-[10px] text-[#45A29E] font-black uppercase tracking-widest opacity-60">Live Log Synchronized</p>
                        </div>
                    </div>
                    <a href="/agent/couriers" class="px-5 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-bold text-white tracking-widest transition-all border border-white/5 shadow-sm uppercase">Full Log</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-[0.2em] text-[#45A29E] font-black border-b border-white/5 bg-white/[0.005]">
                                <th class="px-8 py-5">Consignment ID</th>
                                <th class="px-6 py-5">Destination Hub</th>
                                <th class="px-6 py-5">Freight Matrix</th>
                                <th class="px-8 py-5 text-right">Operational Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($active_deployments as $shipment)
                            <tr class="group hover:bg-white/5 transition-all cursor-pointer">
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-bold text-white group-hover:text-[#64ffda] transition-colors tracking-tight">{{ $shipment->tracking_number }}</span>
                                        <span class="text-[10px] text-[#C5C6C7] opacity-40 font-mono flex items-center gap-2">
                                            <i class="bi bi-clock-history"></i> {{ $shipment->created_at->format('M d, H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-2">
                                        <i class="bi bi-geo-alt-fill text-[#45A29E]/40"></i>
                                        <span class="text-xs font-bold text-[#C5C6C7] tracking-wide">{{ $shipment->to_city }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-white px-2 py-0.5 rounded bg-white/5 border border-white/5 w-fit">PKR {{ number_format($shipment->price) }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @php
                                        $isDelivered = $shipment->status === 'delivered';
                                        $accent = $isDelivered ? '#10b981' : '#f59e0b';
                                    @endphp
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-white/5" style="background: {{ $accent }}10; color: {{ $accent }}; border-color: {{ $accent }}20;">
                                        <span class="w-1.5 h-1.5 rounded-full {{ !$isDelivered ? 'animate-pulse' : '' }}" style="background-color: {{ $accent }}"></span>
                                        <span class="text-[9px] font-black uppercase tracking-widest">{{ str_replace('_', ' ', $shipment->status) }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 opacity-30">
                                        <i class="bi bi-inbox text-5xl"></i>
                                        <p class="text-sm font-bold tracking-widest uppercase">No node activity detected</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Operational Parameters (Sidebar) -->
        <!-- Operational Sidebar -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="glass-panel p-8 rounded-[40px] premium-shadow border border-white/5 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#64ffda]/5 rounded-full blur-[100px] pointer-events-none"></div>
                
                <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-4 bg-[#64ffda] rounded-full"></span>
                    Terminal Information
                </h3>
                
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-[#64ffda]">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] font-black text-[#45A29E] uppercase tracking-widest opacity-60">System Status</span>
                                <span class="text-xs font-bold text-white tracking-wide">Operational</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 p-6 rounded-3xl bg-black/40 border border-white/5 relative group cursor-default">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.8)] animate-pulse"></div>
                        <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Secure Node</span>
                    </div>
                    <p class="text-[10px] text-[#C5C6C7] opacity-60 leading-relaxed font-bold uppercase tracking-[0.05em]">Your terminal is currently encrypted and synchronized with global fleet operations.</p>
                </div>
            </div>

            <!-- Quick Action Hook -->
            <a href="/agent/new-courier" class="group glass-panel p-8 rounded-[40px] premium-shadow border border-[#64ffda]/20 bg-gradient-to-br from-[#64ffda]/5 to-transparent flex items-center justify-between hover:border-[#64ffda]/40 transition-all">
                <div class="flex flex-col gap-1">
                    <h4 class="text-white font-black text-lg group-hover:text-[#64ffda] transition-colors">Start Mission</h4>
                    <p class="text-[10px] text-[#45A29E] font-bold uppercase tracking-widest">Enlist New Parcel</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-[#64ffda] text-[#0B0C10] flex items-center justify-center text-xl shadow-[0_0_20px_rgba(100,255,218,0.3)] group-hover:shadow-[0_0_30px_rgba(100,255,218,0.5)] group-hover:scale-110 transition-all">
                    <i class="bi bi-plus-lg"></i>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
