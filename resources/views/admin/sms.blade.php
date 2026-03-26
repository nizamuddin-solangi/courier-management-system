@extends('admin.layouts.admin')

@section('title', 'SMS Broadcast Center')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Left: Compose Broadcast -->
    <div class="lg:col-span-2 space-y-8">
        <div class="glass-panel p-12 rounded-[40px] border border-white/5 premium-shadow relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#66FCF1]/5 rounded-full blur-[80px] pointer-events-none"></div>
            
            <div class="flex flex-col gap-2 mb-10 relative z-10">
                <h3 class="text-3xl font-bold text-white tracking-tight">Rapid Communications</h3>
                <p class="text-sm text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Multi-Channel Client Notification System</p>
            </div>

            <!-- Tabs -->
            <div class="flex gap-4 mb-8 bg-black/20 p-1.5 rounded-2xl relative z-10 border border-white/5">
                <button onclick="switchSmsTab('general')" id="tab-general" class="flex-1 py-3 px-4 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all bg-[#66FCF1] text-[#0B0C10]">General</button>
                <button onclick="switchSmsTab('route')" id="tab-route" class="flex-1 py-3 px-4 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all text-[#C5C6C7] hover:bg-white/5">Route (From-To)</button>
                <button onclick="switchSmsTab('delivery')" id="tab-delivery" class="flex-1 py-3 px-4 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all text-[#C5C6C7] hover:bg-white/5">Delivery</button>
            </div>

            <!-- General Form -->
            <form id="form-general" class="sms-form space-y-6 relative z-10">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Target Intelligence (Recipients)</label>
                    <div class="relative group">
                        <select class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 appearance-none">
                            <option>All Active Fleet Agents (154)</option>
                            <option>All Registered Clients (1,284)</option>
                            <option>Custom Recipient Group...</option>
                        </select>
                        <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-[#45A29E]">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Message Payload</label>
                    <div class="relative">
                        <textarea class="w-full bg-black/40 border border-white/10 rounded-3xl py-4 px-6 text-sm text-white h-48 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 placeholder-[#C5C6C7]/20" placeholder="Type your secure broadcast message here..."></textarea>
                        <div class="absolute bottom-4 right-6 text-[10px] font-bold text-[#45A29E] opacity-40">0 / 160 CHARS</div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <div class="flex gap-2">
                        <button type="button" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-[#C5C6C7] hover:bg-white/10 transition-all border border-white/5"><i class="bi bi-paperclip"></i></button>
                        <button type="button" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-[#C5C6C7] hover:bg-white/10 transition-all border border-white/5"><i class="bi bi-emoji-smile"></i></button>
                    </div>
                    
                    <button type="submit" class="bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold px-10 py-4 rounded-2xl shadow-[0_10px_20px_-5px_rgba(102,252,241,0.2)] hover:shadow-[0_15px_30px_-5px_rgba(102,252,241,0.4)] hover:-translate-y-1 transition-all duration-300 flex items-center gap-3">
                        Execute Broadcast <i class="bi bi-send-fill text-sm"></i>
                    </button>
                </div>
            </form>

            <!-- Route (From-To) Form -->
            <form id="form-route" class="sms-form hidden space-y-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Origin Node</label>
                        <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" placeholder="e.g. Hub Alpha">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Target Node</label>
                        <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" placeholder="e.g. Sector 7">
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Route Status Update</label>
                    <textarea class="w-full bg-black/40 border border-white/10 rounded-3xl py-4 px-6 text-sm text-white h-32 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" placeholder="Shipment has departed from [Origin] and is en route to [Target]...">Shipment has departed from [Origin] and is en route to [Target]. Expected arrival: 4 hours.</textarea>
                </div>

                <div class="flex items-center justify-end pt-4">
                    <button type="submit" class="bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold px-10 py-4 rounded-2xl shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-3">
                        Transmit Route Update <i class="bi bi-geo-alt-fill text-sm"></i>
                    </button>
                </div>
            </form>

            <!-- Delivery Form -->
            <form id="form-delivery" class="sms-form hidden space-y-6 relative z-10">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Tracking Serial</label>
                    <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40" placeholder="CP-X-0000">
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Delivery Notification Message</label>
                    <textarea class="w-full bg-black/40 border border-white/10 rounded-3xl py-4 px-6 text-sm text-white h-32 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40">Your shipment [Serial] has been successfully delivered. Thank you for choosing CourierPro Premium.</textarea>
                </div>

                <div class="flex items-center justify-end pt-4">
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-400 text-[#0B0C10] font-bold px-10 py-4 rounded-2xl shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-3">
                        Send Delivery Confirmation <i class="bi bi-check-circle-fill text-sm"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- History Section -->
        <div class="glass-panel p-12 rounded-[40px] border border-white/5 premium-shadow">
            <h4 class="text-base font-bold tracking-widest text-[#45A29E] uppercase opacity-70 mb-8">Transmission History</h4>
            <div class="space-y-4">
                @foreach([
                    ['title' => 'System Maintenance Alert', 'time' => '1 hour ago', 'status' => 'Delivered'],
                    ['title' => 'New Protocol Deployment', 'time' => '4 hours ago', 'status' => 'Delivered'],
                    ['title' => 'Client Holiday Greeting', 'time' => '2 days ago', 'status' => 'Completed']
                ] as $sms)
                <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl group hover:bg-white/[0.05] transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#66FCF1]/10 flex items-center justify-center text-[#66FCF1]"><i class="bi bi-chat-left-dots"></i></div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-white">{{ $sms['title'] }}</span>
                            <span class="text-[10px] text-[#45A29E] opacity-60 uppercase font-bold">{{ $sms['time'] }}</span>
                        </div>
                    </div>
                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-md bg-green-500/10 text-green-400 border border-green-500/20">{{ $sms['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right: Stats & Quota -->
    <div class="space-y-8">
        <div class="glass-panel p-12 rounded-[40px] border border-white/5 premium-shadow bg-gradient-to-br from-white/[0.03] to-transparent">
            <h4 class="text-sm font-bold tracking-widest text-[#45A29E] uppercase opacity-70 mb-10">Node Quota Status</h4>
            
            <div class="space-y-8">
                <div class="flex flex-col items-center gap-4">
                    <div class="relative w-40 h-40 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/5" />
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="440" stroke-dashoffset="132" class="text-[#66FCF1] drop-shadow-[0_0_8px_rgba(102,252,241,0.5)]" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-3xl font-extrabold text-white">70%</span>
                            <span class="text-[9px] font-bold text-[#45A29E] uppercase">Credits Used</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/5 text-center">
                        <span class="block text-xs text-[#45A29E] font-bold">SENT TODAY</span>
                        <span class="text-xl font-bold text-white">4,281</span>
                    </div>
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/5 text-center">
                        <span class="block text-xs text-[#45A29E] font-bold">REMAINING</span>
                        <span class="text-xl font-bold text-white">1,500</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel p-12 rounded-[40px] border border-white/5 premium-shadow">
            <h4 class="text-sm font-bold tracking-widest text-[#45A29E] uppercase opacity-70 mb-8">Security Directives</h4>
            <ul class="space-y-5 text-sm text-[#C5C6C7] opacity-80">
                <li class="flex items-start gap-3"><i class="bi bi-shield-check text-[#66FCF1]"></i> All messages are end-to-end encrypted.</li>
                <li class="flex items-start gap-3"><i class="bi bi-shield-check text-[#66FCF1]"></i> High-volume broadcasts require Level 4 auth.</li>
                <li class="flex items-start gap-3"><i class="bi bi-shield-check text-[#66FCF1]"></i> Automated spam filtering is active.</li>
            </ul>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function switchSmsTab(tabId) {
        // Toggle Forms
        document.querySelectorAll('.sms-form').forEach(f => f.classList.add('hidden'));
        document.getElementById('form-' + tabId).classList.remove('hidden');

        // Toggle Buttons
        const buttons = {
            'general': document.getElementById('tab-general'),
            'route': document.getElementById('tab-route'),
            'delivery': document.getElementById('tab-delivery')
        };

        Object.keys(buttons).forEach(id => {
            if (id === tabId) {
                buttons[id].classList.add('bg-[#66FCF1]', 'text-[#0B0C10]');
                buttons[id].classList.remove('text-[#C5C6C7]', 'hover:bg-white/5');
            } else {
                buttons[id].classList.remove('bg-[#66FCF1]', 'text-[#0B0C10]');
                buttons[id].classList.add('text-[#C5C6C7]', 'hover:bg-white/5');
            }
        });
    }
</script>
@endpush
@endsection
