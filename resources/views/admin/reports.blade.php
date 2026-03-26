@extends('admin.layouts.admin')

@section('title', 'Fleet Intelligence Reports')

@section('content')
<div class="space-y-12 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Report Hero Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-8 rounded-3xl border border-white/5 premium-shadow bg-gradient-to-br from-white/[0.03] to-transparent">
            <h4 class="text-[10px] font-bold tracking-[0.2em] text-[#45A29E] uppercase opacity-60 mb-1">Mtd Throughput</h4>
            <div class="text-3xl font-bold text-white tracking-tight">8,421</div>
            <p class="text-xs text-[#66FCF1] mt-2 font-bold">+18.4% <span class="text-[#C5C6C7] opacity-40 font-medium ml-1">vs Latent Period</span></p>
        </div>
        <div class="glass-panel p-8 rounded-3xl border border-white/5 premium-shadow bg-gradient-to-br from-white/[0.03] to-transparent">
            <h4 class="text-[10px] font-bold tracking-[0.2em] text-[#45A29E] uppercase opacity-60 mb-1">Avg Lead Time</h4>
            <div class="text-3xl font-bold text-white tracking-tight">4.2 Hrs</div>
            <p class="text-xs text-[#66FCF1] mt-2 font-bold">-0.8 Hrs <span class="text-[#C5C6C7] opacity-40 font-medium ml-1">Optimization Gain</span></p>
        </div>
        <div class="glass-panel p-8 rounded-3xl border border-white/5 premium-shadow bg-gradient-to-br from-white/[0.03] to-transparent">
            <h4 class="text-[10px] font-bold tracking-[0.2em] text-[#45A29E] uppercase opacity-60 mb-1">Revenue Yield</h4>
            <div class="text-3xl font-bold text-white tracking-tight">$42.8k</div>
            <p class="text-xs text-[#66FCF1] mt-2 font-bold">+12% <span class="text-[#C5C6C7] opacity-40 font-medium ml-1">Organic Growth</span></p>
        </div>
    </div>

    <!-- Analytics Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Throughput Velocity Chart -->
        <div class="lg:col-span-2 glass-panel p-10 rounded-[40px] border border-white/5 premium-shadow overflow-hidden group">
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-[#66FCF1]/5 rounded-full blur-[80px] pointer-events-none group-hover:scale-150 transition-all duration-700"></div>
            
            <div class="flex items-center justify-between mb-10 relative z-10">
                <div class="flex flex-col gap-1">
                    <h3 class="text-xl font-bold text-white tracking-tight">Throughput Velocity</h3>
                    <p class="text-[10px] text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Fleet Performance Vector Analysis</p>
                </div>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-[#C5C6C7] hover:bg-white/10 transition-all"><i class="bi bi-download"></i></button>
                    <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-[#C5C6C7] hover:bg-white/10 transition-all"><i class="bi bi-printer"></i></button>
                </div>
            </div>

            <div class="h-[360px] relative z-10">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Regional Density Leaderboard -->
        <div class="glass-panel p-10 rounded-[40px] border border-white/5 premium-shadow">
            <h3 class="text-xl font-bold text-white tracking-tight mb-8">Node Density Leaders</h3>
            <div class="space-y-6">
                @foreach([
                    ['name' => 'Downtown DC', 'val' => '42%', 'color' => '#66FCF1'],
                    ['name' => 'Techno-Park Node', 'val' => '28%', 'color' => '#45A29E'],
                    ['name' => 'Suburban Core', 'val' => '18%', 'color' => '#00D2FF'],
                    ['name' => 'Industrial Port', 'val' => '12%', 'color' => '#FF9F43']
                ] as $reg)
                <div class="space-y-2 group">
                    <div class="flex justify-between items-center text-[10px] font-bold">
                        <span class="text-[#C5C6C7] group-hover:text-white transition-colors">{{ $reg['name'] }}</span>
                        <span class="text-[#66FCF1]">{{ $reg['val'] }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden border border-white/5">
                        <div class="h-full bg-gradient-to-r from-[#45A29E] to-{{ $reg['color'] }} w-{{ $reg['val'] }} rounded-full group-hover:shadow-[0_0_8px_rgba(102,252,241,0.3)] transition-all" style="width: {{ $reg['val'] }}; background-color: {{ $reg['color'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 p-6 rounded-3xl border border-dashed border-[#45A29E]/30 text-center opacity-60 group hover:opacity-100 transition-opacity">
                <p class="text-xs font-bold text-[#45A29E] mb-2 uppercase tracking-tighter">Predictive Analysis</p>
                <p class="text-sm text-white font-medium opacity-80 leading-relaxed italic">"Fleet density is projected to expand by 14% in suburban nodes over the next fiscal quarter."</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Performance Yield',
                data: [1200, 1900, 1500, 2400, 2100, 2800],
                borderColor: '#66FCF1',
                borderWidth: 4,
                tension: 0.5,
                fill: false,
                pointBackgroundColor: '#0B0C10',
                pointBorderColor: '#66FCF1',
                pointBorderWidth: 3,
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
                }
            },
            scales: {
                y: {
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
