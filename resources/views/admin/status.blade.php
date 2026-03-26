@extends('admin.layouts.admin')

@section('title', 'Fleet Status Distribution')

@section('content')
<div class="space-y-12 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Distribution Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <div class="glass-panel p-12 rounded-[40px] border border-white/5 premium-shadow relative overflow-hidden">
            <div class="absolute -left-20 -top-20 w-64 h-64 bg-[#66FCF1]/5 rounded-full blur-[80px] pointer-events-none"></div>
            
            <div class="flex flex-col gap-1 mb-8">
                <h3 class="text-3xl font-bold text-white tracking-tight">Real-time Node Distribution</h3>
                <p class="text-sm text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Fleet-Wide Operational Analysis</p>
            </div>

            <div class="h-[500px] relative">
                <canvas id="statusDonutChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-xs font-bold tracking-widest text-[#45A29E] uppercase opacity-60 pl-2">Distribution Metrics</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach([
                    ['label' => 'Delivered (Core)', 'val' => '1,102', 'color' => '#45A29E', 'perc' => '86%'],
                    ['label' => 'In-Transit (Flow)', 'val' => '154', 'color' => '#66FCF1', 'perc' => '12%'],
                    ['label' => 'On-Hold (Halt)', 'val' => '28', 'color' => '#FF4B5C', 'perc' => '2%'],
                    ['label' => 'Pending (Wait)', 'val' => '12', 'color' => '#FF9F43', 'perc' => '< 1%']
                ] as $stat)
                <div class="glass-panel p-8 rounded-3xl border border-white/5 premium-shadow hover:bg-white/5 transition-all">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $stat['color'] }}"></div>
                        <span class="text-xs font-bold text-[#45A29E] uppercase tracking-widest">{{ $stat['label'] }}</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold text-white tracking-tight">{{ $stat['val'] }}</span>
                        <span class="text-xs font-bold text-[#66FCF1]">{{ $stat['perc'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="glass-panel p-8 rounded-3xl border border-white/5 bg-gradient-to-r from-white/[0.03] to-transparent">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold text-white">System Efficiency Rating</span>
                    <span class="text-sm font-bold text-[#66FCF1]">98.2% Optimal</span>
                </div>
                <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#45A29E] to-[#66FCF1] w-[98.2%] rounded-full shadow-[0_0_15px_rgba(102,252,241,0.5)]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Node Heatmap Placeholder -->
    <div class="glass-panel p-12 rounded-[40px] border border-white/5 premium-shadow">
        <div class="flex flex-col gap-2 mb-10 text-center">
            <h3 class="text-2xl font-bold text-white tracking-tight">Geographic Node Pulse</h3>
            <p class="text-xs text-[#45A29E] font-bold uppercase tracking-widest opacity-60">Regional Density Matrix</p>
        </div>
        
        <div class="h-64 flex items-center justify-center opacity-30 relative group">
            <div class="absolute inset-x-0 inset-y-0 bg-[radial-gradient(var(--accent-primary)/.1_1px,transparent_1px)] bg-[size:32px_32px]"></div>
            <div class="flex flex-col items-center gap-4 relative z-10 transition-transform duration-500 group-hover:scale-110">
                <i class="bi bi-geo-alt-fill text-6xl text-[#66FCF1] drop-shadow-[0_0_20px_rgba(102,252,241,0.5)] animate-bounce"></i>
                <p class="text-sm font-bold tracking-widest uppercase text-[#C5C6C7]">Scanning Local Satellites...</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('statusDonutChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'In-Transit', 'On-Hold', 'Pending'],
            datasets: [{
                data: [1102, 154, 28, 12],
                backgroundColor: ['#45A29E', '#66FCF1', '#FF4B5C', '#FF9F43'],
                borderColor: '#0B0C10',
                borderWidth: 8,
                hoverBorderColor: '#0B0C10',
                hoverBorderWidth: 8,
                borderJoinStyle: 'round',
                hoverOffset: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2833',
                    titleFont: { size: 12, weight: 'bold' },
                    padding: 12,
                    displayColors: false,
                }
            }
        }
    });
});
</script>
@endpush
@endsection
