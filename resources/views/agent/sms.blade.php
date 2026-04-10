@extends('agent.layouts.agent')

@section('title', 'Branch SMS Dispatch')

@section('content')
<div class="max-w-6xl mx-auto space-y-10 animate-fade-in pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Notification <span class="text-[#64ffda]">Terminal</span></h2>
            <p class="text-[#C5C6C7] opacity-60 mt-1">Standardized automated SMS alerts for branch operations.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="px-5 py-3 rounded-2xl bg-[#64ffda]/5 border border-[#64ffda]/20 flex flex-col items-center">
                <span class="text-[10px] font-black text-[#64ffda] uppercase tracking-[0.2em] mb-1">Queue Status</span>
                <span class="text-xl font-black text-white">ONLINE</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Send Alert Section -->
        <div class="glass-panel p-10 rounded-[40px] premium-shadow border border-white/5 space-y-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03]">
                <i class="bi bi-chat-left-dots text-9xl"></i>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-bold text-white tracking-tight">Dispatch Trigger</h3>
                <p class="text-xs text-[#45A29E] font-medium opacity-60">Authorize manual dispatch or delivery notifications</p>
            </div>

            <form class="space-y-6" method="POST" action="{{ route('agent.sms.send') }}">
                @csrf
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Select Consignment</label>
                    <select name="courier_id" required class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-4 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all appearance-none cursor-pointer">
                        @foreach($couriers as $shipment)
                            <option value="{{ $shipment->id }}">{{ $shipment->tracking_number }} — {{ $shipment->receiver_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" name="sms_type" value="dispatch" class="group p-6 rounded-3xl bg-white/5 border border-white/5 hover:border-[#64ffda]/30 transition-all text-left">
                        <i class="bi bi-truck text-2xl text-[#64ffda] mb-4 block group-hover:scale-110 transition-transform"></i>
                        <span class="block text-sm font-bold text-white mb-1">Dispatch Alert</span>
                        <span class="block text-[10px] text-[#45A29E] font-medium tracking-tight opacity-60 italic">Package departure notification</span>
                    </button>
                    <button type="submit" name="sms_type" value="delivery" class="group p-6 rounded-3xl bg-white/5 border border-white/5 hover:border-emerald-500/30 transition-all text-left">
                        <i class="bi bi-check2-all text-2xl text-emerald-400 mb-4 block group-hover:scale-110 transition-transform"></i>
                        <span class="block text-sm font-bold text-white mb-1">Delivery Sync</span>
                        <span class="block text-[10px] text-[#45A29E] font-medium tracking-tight opacity-60 italic">Arrival confirmation alert</span>
                    </button>
                </div>

                <div class="p-6 rounded-3xl bg-white/[0.02] border border-white/5 flex items-start gap-4">
                    <i class="bi bi-info-circle text-[#64ffda] mt-0.5"></i>
                    <p class="text-xs text-[#C5C6C7] opacity-60 leading-relaxed font-medium">Standard carrier charges apply. SMS will be dispatched via the system's global SMS gateway to the consignee's registered mobile number.</p>
                </div>

                <button type="submit" name="sms_type" value="dispatch" class="w-full py-5 rounded-2xl bg-gradient-to-r from-[#45A29E] to-[#64ffda] text-[#0B0C10] font-black text-xs uppercase tracking-widest shadow-xl hover:scale-[1.01] active:scale-[0.99] transition-all">
                    Initiate Transmission (Dispatch)
                </button>
            </form>
        </div>

        <!-- History Section -->
        <div class="glass-panel p-10 rounded-[40px] premium-shadow border border-white/5 flex flex-col">
            <h3 class="text-sm font-black text-white uppercase tracking-widest border-b border-white/10 pb-6 mb-6">Recent Branch Transmissions</h3>
            <div class="flex-1 space-y-6 overflow-y-auto no-scrollbar max-h-[500px] pr-2">
                @forelse($couriers->take(8) as $shipment)
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 group hover:bg-white/[0.08] transition-all">
                    <div class="w-10 h-10 rounded-xl bg-[#64ffda]/10 flex items-center justify-center text-[#64ffda] border border-[#64ffda]/20">
                        <i class="bi bi-chat-text text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] font-black text-[#64ffda] uppercase tracking-[0.2em]">{{ $shipment->tracking_number }}</span>
                            <span class="text-[10px] text-[#45A29E] font-bold opacity-40 italic">2m ago</span>
                        </div>
                        <p class="text-[11px] text-[#C5C6C7] leading-relaxed line-clamp-2">Alert: Package {{ $shipment->tracking_number }} is out for delivery. Contact branch for info.</p>
                    </div>
                </div>
                @empty
                 <div class="flex flex-col items-center justify-center h-full opacity-20 py-10">
                    <i class="bi bi-chat-dots text-4xl mb-4"></i>
                    <span class="text-xs font-bold uppercase tracking-widest">Archive Empty</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
