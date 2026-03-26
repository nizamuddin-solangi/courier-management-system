@props(['label', 'value', 'change', 'icon', 'color' => '#66FCF1'])

<div class="glass-panel p-6 rounded-3xl premium-shadow border border-white/5 relative overflow-hidden group hover:border-white/10 transition-all duration-300">
    <!-- Icon Backdrop Glow -->
    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full opacity-10 blur-2xl transition-all duration-500 group-hover:opacity-20" style="background-color: {{ $color }}"></div>
    
    <div class="flex items-start justify-between relative z-10">
        <div class="flex flex-col gap-1">
            <span class="text-xs font-bold tracking-widest text-[#45A29E] uppercase opacity-70">{{ $label }}</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-white tracking-tight">{{ $value }}</span>
                <span @class([
                    'text-[10px] font-bold px-1.5 py-0.5 rounded-md flex items-center gap-1',
                    'bg-green-500/10 text-green-400' => $change >= 0,
                    'bg-red-500/10 text-red-400' => $change < 0,
                ])>
                    <i class="bi bi-arrow-{{ $change >= 0 ? 'up-short' : 'down-short' }}"></i>
                    {{ abs($change) }}%
                </span>
            </div>
        </div>
        
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shadow-inner transition-all duration-300 group-hover:scale-110" style="background-color: {{ $color }}20; color: {{ $color }}">
            <i class="bi {{ $icon }}"></i>
        </div>
    </div>

    <!-- Mini Chart Placeholder Area -->
    <div class="mt-6 flex items-end gap-1 h-8 opacity-20 group-hover:opacity-40 transition-opacity">
        @for($i = 0; $i < 12; $i++)
            <div class="flex-1 rounded-t-sm" style="background-color: {{ $color }}; height: {{ rand(20, 100) }}%"></div>
        @endfor
    </div>
</div>
