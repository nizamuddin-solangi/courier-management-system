@props(['href', 'icon', 'label', 'active' => false])

<a href="{{ $href }}" @class([
    'flex items-center gap-4 px-4 py-2.5 text-sm font-medium rounded-xl transition-all group duration-200',
    'bg-[#66FCF1]/10 text-[#66FCF1] border border-[#66FCF1]/20 shadow-[0_0_15px_-3px_rgba(102,252,241,0.2)]' => $active,
    'text-[#C5C6C7] hover:text-white hover:bg-white/5 border border-transparent hover:border-white/10' => !$active,
])>
    <i @class([
        "bi {$icon} text-lg transition-transform duration-200",
        'scale-110' => $active,
        'group-hover:scale-110 opacity-70 group-hover:opacity-100' => !$active,
    ])></i>
    <span class="flex-1">{{ $label }}</span>
    @if($active)
        <div class="w-1.5 h-1.5 rounded-full bg-[#66FCF1] shadow-[0_0_8px_rgba(102,252,241,1)]"></div>
    @endif
</a>
