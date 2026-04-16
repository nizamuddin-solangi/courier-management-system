@extends('agent.layouts.agent')

@section('title', 'Shipment Registration')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in pb-12">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Register <span class="text-[#64ffda]">New Asset</span></h2>
            <p class="text-[#C5C6C7] opacity-60 mt-1">Initiating secure logistics chain from branch {{ $current_agent->branch_name }}</p>
        </div>
        <div class="glass-panel px-4 py-2 rounded-xl flex items-center gap-3 border border-white/5">
            <div class="w-2 h-2 rounded-full bg-[#64ffda] animate-pulse shadow-[0_0_10px_#64ffda]"></div>
            <span class="text-[10px] font-bold text-white uppercase tracking-widest">{{ $current_agent->agent_code }} TERMINAL</span>
        </div>
    </div>

    <style>
        .error-msg {
            color: #ff4d4d;
            font-size: 10px;
            font-weight: 700;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>

    @if(session('success'))
    <div class="glass-panel p-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/5 text-emerald-400 text-sm font-bold flex items-center gap-3 animate-slide-up">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="form-notice">
        <i class="bi bi-info-circle-fill"></i>
        <p class="text-[10px] font-bold text-white uppercase tracking-widest">Notice: Please complete all required fields. Real-time validation is active to ensure data integrity.</p>
    </div>

    <form action="/agent/store-courier" method="POST" class="space-y-8">
        @csrf
        <!-- Logistics Identity -->
        <div class="glass-panel p-8 rounded-[40px] premium-shadow border border-white/5 space-y-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <i class="bi bi-qr-code-scan text-8xl"></i>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <label class="text-[11px] font-black text-[#45A29E] uppercase tracking-[0.2em] pl-1">Service Timeline</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-[#64ffda] transition-colors">
                                <i class="bi bi-calendar-event text-lg"></i>
                            </div>
                            <input type="date" name="delivery_date" required
                                min="{{ date('Y-m-d') }}" value="{{ old('delivery_date') }}"
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#64ffda]/50 transition-all">
                            <div class="error-msg"></div>
                        </div>
                        @error('delivery_date') <div class="error-msg">{{ $message }}</div> @enderror
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-[#64ffda] transition-colors">
                                <i class="bi bi-clock text-lg"></i>
                            </div>
                            <input type="time" name="delivery_time" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#64ffda]/50 transition-all">
                            <div class="error-msg"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-[#45A29E] uppercase tracking-[0.2em] pl-1">Origin Node</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-[#64ffda] transition-colors">
                            <i class="bi bi-geo-alt text-lg"></i>
                        </div>
                        <input type="text" name="from_city" value="{{ $current_agent->city }}" readonly
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-sm text-white/60 cursor-not-allowed">
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Consignor Details -->
            <div class="glass-panel p-8 rounded-[40px] border border-white/5 space-y-6">
                <h3 class="text-sm font-black text-white uppercase tracking-widest border-b border-white/10 pb-4">Consignor (From)</h3>
                
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Full Identity</label>
                    <input type="text" name="sender_name" placeholder="Name or Organization" required
                        pattern="[a-zA-Z\s]+" title="Real Pattern: Only letters and spaces allowed"
                        value="{{ old('sender_name') }}"
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all">
                    @error('sender_name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Secure Contact</label>
                    <input type="tel" name="sender_phone" placeholder="+92 XXX XXXXXXX" required
                        pattern="[0-9+]+" title="Real Pattern: Only digits and + allowed"
                        value="{{ old('sender_phone') }}"
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all">
                    @error('sender_phone') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Physical Address</label>
                    <textarea name="sender_address" rows="3" placeholder="Full pickup coordinates..." required
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all resize-none"></textarea>
                    <div class="error-msg"></div>
                </div>
            </div>

            <!-- Consignee Details -->
            <div class="glass-panel p-8 rounded-[40px] border border-white/5 space-y-6">
                <h3 class="text-sm font-black text-white uppercase tracking-widest border-b border-white/10 pb-4">Consignee (To)</h3>
                
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Recipient Identity</label>
                    <input type="text" name="receiver_name" placeholder="Receiver full name" required
                        pattern="[a-zA-Z\s]+" title="Real Pattern: Only letters and spaces allowed"
                        value="{{ old('receiver_name') }}"
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all">
                    @error('receiver_name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-1 flex gap-4">
                    <div class="w-1/2 space-y-1">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">City Hub</label>
                        <input type="text" name="to_city" placeholder="Lahore, KHI..." required
                            class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all">
                        <div class="error-msg"></div>
                    </div>
                    <div class="w-1/2 space-y-1">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Contact No</label>
                        <input type="tel" name="receiver_phone" placeholder="+92 XXX..." required
                            pattern="[0-9+]+" title="Real Pattern: Only digits and + allowed"
                            value="{{ old('receiver_phone') }}"
                            class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all">
                        @error('receiver_phone') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Delivery Destination</label>
                    <textarea name="receiver_address" rows="3" placeholder="Full street address..." required
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all resize-none"></textarea>
                    <div class="error-msg"></div>
                </div>
            </div>
        </div>

        <!-- Shipment Specs -->
        <div class="glass-panel p-8 rounded-[40px] border border-white/5">
            <h3 class="text-sm font-black text-white uppercase tracking-widest border-b border-white/10 pb-4 mb-6">Shipment Parameters</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Asset Category</label>
                    <select name="parcel_type" class="w-full bg-black/20 border border-white/10 rounded-xl py-4 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all outline-none">
                        <option class="bg-[#0B0C10]">Documents</option>
                        <option class="bg-[#0B0C10]">Apparel/Fabrics</option>
                        <option class="bg-[#0B0C10]">Electronics</option>
                        <option class="bg-[#0B0C10]">Industrial Parts</option>
                        <option class="bg-[#0B0C10]">Medical Supplies</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" placeholder="0.0" required
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-4 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all outline-none">
                    <div class="error-msg"></div>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Freight Cost</label>
                    <input type="number" name="price" placeholder="PKR" required
                        class="w-full bg-black/20 border border-white/10 rounded-xl py-4 px-4 text-sm text-white focus:ring-1 focus:ring-[#64ffda]/50 transition-all outline-none">
                    <div class="error-msg"></div>
                </div>
            </div>

            <button type="submit" class="w-full py-5 rounded-2xl bg-gradient-to-r from-[#45A29E] to-[#64ffda] text-[#0B0C10] font-black text-sm uppercase tracking-[0.2em] shadow-[0_20px_40px_-10px_rgba(100,255,218,0.3)] hover:shadow-[0_25px_50px_-12px_rgba(100,255,218,0.4)] hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3">
                <i class="bi bi-shield-check text-xl"></i>
                Finalize Shipment & Generate Node ID
            </button>
        </div>
    </form>
</div>
@endsection
