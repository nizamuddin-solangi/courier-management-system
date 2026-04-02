@extends('admin.layouts.admin')

@section('title', 'System Intelligence')

@section('content')
<div class="space-y-6 w-full animate-fade-in">
 
     <!-- Hero Stats Grid -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stats-card 
            label="Active Fleet Shipments" 
            value="{{ number_format($total_shipments) }}" 
            change="0" 
            icon="bi-box-seam" 
            color="#66FCF1" 
        />
        <x-stats-card 
            label="Successful Deliveries" 
            value="{{ number_format($delivered) }}" 
            change="0" 
            icon="bi-check2-all" 
            color="#45A29E" 
        />
        <x-stats-card 
            label="In-Transit Nodes" 
            value="{{ number_format($in_progress) }}" 
            change="0" 
            icon="bi-truck-flatbed" 
            color="#00D2FF" 
        />
        <x-stats-card 
            label="Pending Confirmations" 
            value="{{ number_format($pending) }}" 
            change="0" 
            icon="bi-clock-history" 
            color="#FF9F43" 
        />
    </div>

    <!-- Main Analytics & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Live Volume Chart -->
        <div class="lg:col-span-2 glass-panel p-8 rounded-3xl border border-white/5 premium-shadow">
            <div class="flex items-center justify-between mb-8">
                <div class="flex flex-col gap-1">
                    <h3 class="text-2xl font-bold text-white tracking-tight">Fleet Volume Insights</h3>
                    <p class="text-sm text-[#45A29E] font-medium opacity-70">Real-time throughput analysis</p>
                </div>
                <div class="flex gap-2 p-1.5 bg-white/5 rounded-xl border border-white/5 h-12">
                    <button class="px-5 text-sm font-bold text-[#66FCF1] bg-[#66FCF1]/10 rounded-lg shadow-sm">7 Days</button>
                    <button class="px-5 text-sm font-bold text-[#C5C6C7] hover:bg-white/5 rounded-lg transition-all">30 Days</button>
                </div>
            </div>
            
            <div class="h-[400px] relative">
                <canvas id="shipmentVolumeChart"></canvas>
            </div>
        </div>

        <!-- System Pulse / Activity -->
        <div class="glass-panel p-8 rounded-3xl border border-white/5 premium-shadow">
            <h3 class="text-2xl font-bold text-white tracking-tight mb-8 flex items-center gap-3">
                <span class="w-3.5 h-3.5 rounded-full bg-red-500 animate-pulse shadow-[0_0_12px_rgba(239,68,68,1)]"></span>
                System Pulse
            </h3>
            
            <div class="space-y-6">
                <!-- Progress Pulse Items -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-bold">
                        <span class="text-[#C5C6C7]">Active Delivery Agents</span>
                        <span class="text-[#66FCF1]">92% Capacity</span>
                    </div>
                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                        <div class="h-full bg-gradient-to-r from-[#45A29E] to-[#66FCF1] w-[92%] rounded-full shadow-[0_0_10px_rgba(102,252,241,0.3)]"></div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-bold">
                        <span class="text-[#C5C6C7]">Server Health Index</span>
                        <span class="text-[#00D2FF]">Optimal (12ms)</span>
                    </div>
                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-[#00D2FF] w-[98%] rounded-full"></div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/5 space-y-4">
                    <h4 class="text-xs font-bold tracking-widest text-[#45A29E] uppercase opacity-60">Recent Telemetry</h4>
                    
                    @foreach(['Shipment #4829 delivered in Downtown', 'New agent registered in Sector 4', 'API connectivity confirmed for Global-Scan'] as $log)
                    <div class="flex items-start gap-4 group">
                        <div class="w-2 h-2 rounded-full mt-2 bg-[#66FCF1] group-hover:scale-150 transition-transform"></div>
                        <p class="text-sm text-[#C5C6C7] font-medium leading-tight opacity-70 group-hover:opacity-100 transition-opacity">{{ $log }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Active Deployments Table -->
    <div class="glass-panel overflow-hidden rounded-3xl border border-white/5 premium-shadow">
        <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
            <div class="flex flex-col gap-1">
                <h3 class="text-2xl font-bold text-white tracking-tight">Active Deployments</h3>
                <p class="text-sm text-[#45A29E] font-medium opacity-70">Real-time tracking of current transit nodes</p>
            </div>
            <a href="/admin/couriers" class="text-sm font-bold text-[#66FCF1] hover:underline decoration-2 underline-offset-4 decoration-[#66FCF1]/30">View Detailed Registry <i class="bi bi-arrow-right ml-1"></i></a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs uppercase tracking-widest text-[#45A29E] font-bold opacity-60 border-b border-white/5">
                        <th class="px-8 py-5">Transit ID</th>
                        <th class="px-8 py-5">Consignee Entity</th>
                        <th class="px-8 py-5">Target Node</th>
                        <th class="px-8 py-5">Status Matrix</th>
                        <th class="px-8 py-5">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($active_deployments as $ship)
                    @php
                        $color = '#66FCF1';
                        if($ship->status == 'pending') $color = '#FF9F43';
                        if($ship->status == 'delivered') $color = '#45A29E';
                        if($ship->status == 'cancelled') $color = '#EF4444';
                    @endphp
                    <tr class="group hover:bg-white/[0.03] transition-colors">
                        <td class="px-8 py-5 text-base font-bold text-white tracking-tight group-hover:text-[#66FCF1] transition-colors">{{ $ship->tracking_number }}</td>
                        <td class="px-8 py-5 text-base text-[#C5C6C7] font-medium opacity-80">{{ $ship->receiver_name }}</td>
                        <td class="px-8 py-5 text-base text-[#C5C6C7] font-medium opacity-80">{{ $ship->to_city }}</td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border" style="background-color: {{ $color }}15; color: {{ $color }}; border-color: {{ $color }}30">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $color }}"></span>
                                {{ ucfirst(str_replace('_', ' ', $ship->status)) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm text-[#45A29E] font-medium opacity-60 italic">{{ $ship->created_at->format('h:i A \o\n M d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('shipmentVolumeChart').getContext('2d');
    
    // Gradient setup
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 252, 241, 0.4)');
    gradient.addColorStop(1, 'rgba(102, 252, 241, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Global Shipments',
                data: {!! json_encode($chart_data) !!},
                borderColor: '#66FCF1',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: gradient,
                pointBackgroundColor: '#66FCF1',
                pointBorderColor: '#0B0C10',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2833',
                    titleColor: '#66FCF1',
                    bodyColor: '#C5C6C7',
                    borderColor: 'rgba(102, 252, 241, 0.2)',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(197, 198, 199, 0.05)', drawBorder: false },
                    ticks: { color: '#45A29E', font: { size: 10, weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#C5C6C7', font: { size: 11, weight: 'medium' } }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
