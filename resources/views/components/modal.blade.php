@props(['id', 'title'])

<div id="{{ $id }}" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden p-4 md:inset-0 h-modal md:h-full transition-opacity duration-300">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('{{ $id }}')"></div>
    
    <div class="relative w-full max-w-2xl h-full md:h-auto mx-auto mt-20 animate-slide-up">
        <div class="glass-panel relative rounded-[40px] premium-shadow border border-white/10 overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between p-8 border-b border-white/5 bg-white/[0.02]">
                <div class="flex flex-col gap-1">
                    <h3 class="text-2xl font-bold text-white tracking-tight">{{ $title }}</h3>
                    <p class="text-xs text-[#45A29E] font-medium opacity-70">Please fill in the secure data fields below</p>
                </div>
                <button onclick="closeModal('{{ $id }}')" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-[#C5C6C7] hover:text-white hover:bg-white/10 transition-all border border-white/5">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endpush
