@extends('agent.layouts.agent')

@section('title', 'Profile Settings')

@section('content')
<style>
    .avatar-box {
        width: 128px;
        height: 128px;
        border-radius: 32px;
        background: linear-gradient(135deg, #64ffda, #45A29E);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 900;
        color: #0B0C10;
        box-shadow: 0 0 0 4px #0B0C10, 0 15px 45px rgba(0, 0, 0, 0.5);
        position: relative;
        cursor: pointer;
        flex-shrink: 0;
        margin: 0 auto;
        border: 2px solid rgba(100, 255, 218, 0.3);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .avatar-box:hover {
        transform: scale(1.05);
        border-color: #64ffda;
    }

    .avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        opacity: 0;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(4px);
    }

    .avatar-box:hover .avatar-overlay {
        opacity: 1;
    }

    .error-msg {
        color: #ff4d4d;
        font-size: 10px;
        font-weight: 700;
        margin-top: 5px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    input:invalid:not(:placeholder-shown) {
        border-color: #ff4d4d !important;
    }
</style>

<div class="max-w-5xl mx-auto space-y-8 animate-fade-in pb-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Account <span class="text-[#64ffda]">Security & Info</span></h2>
            <p class="text-[#45A29E] font-medium mt-1">Manage your professional identity and terminal access</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="glass-panel px-4 py-2 rounded-xl flex items-center gap-3 border border-white/5">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold text-white uppercase tracking-widest">Active Session</span>
            </div>
        </div>
    </div>

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

    <form action="{{ route('agent.profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        <!-- Left Column: Avatar & Branch -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Avatar Card -->
            <div class="glass-panel p-8 rounded-[40px] text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-b from-[#64ffda]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="relative pt-4 mb-8">
                    <label for="imageUpload" class="avatar-box" id="avatarBox"
                           style="{{ $agent->image ? 'background: url(/uploads/'.$agent->image.') center/cover no-repeat; color: transparent;' : '' }}">
                        @if(!$agent->image)
                            <span id="initialsDisplay">{{ strtoupper(substr($agent->name, 0, 1)) }}</span>
                        @endif
                        <div class="avatar-overlay">
                            <i class="bi bi-camera-fill text-white text-2xl"></i>
                            <span class="text-white text-[10px] font-black uppercase tracking-widest">Update</span>
                        </div>
                        <input type="file" name="image" id="imageUpload" class="hidden" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this)">
                    </label>
                    @error('image') <div class="error-msg mt-4">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-4 mb-6">
                    <h3 class="text-xl font-bold text-white leading-tight">{{ $agent->name }}</h3>
                    <p class="text-xs text-[#45A29E] font-black uppercase tracking-widest">{{ $agent->agent_code }}</p>
                </div>
                
                <div class="flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                    <i class="bi bi-geo-alt text-[#64ffda]"></i>
                    <span class="text-[10px] font-bold text-[#C5C6C7] uppercase tracking-widest">{{ $agent->branch_name }} HUB</span>
                </div>
            </div>

            <!-- Branch Access (Read Only) -->
            <div class="glass-panel p-8 rounded-[40px] border border-white/5 space-y-6">
                <h3 class="text-xs font-black text-white uppercase tracking-widest border-b border-white/5 pb-4">Assigned Parameters</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-black/20 p-3 rounded-xl border border-white/5">
                        <span class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Base City</span>
                        <span class="text-xs font-bold text-white">{{ $agent->city }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-black/20 p-3 rounded-xl border border-white/5">
                        <span class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest">Status</span>
                        <span class="px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-400 text-[9px] font-black uppercase border border-emerald-500/20">Active Node</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Form Fields -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Information Grid -->
            <div class="glass-panel p-8 rounded-[40px] border border-white/5 space-y-8">
                <div class="flex items-center gap-4 border-b border-white/5 pb-6 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#64ffda]/10 flex items-center justify-center text-[#64ffda]">
                        <i class="bi bi-person-badge text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-tight">Identity Details</h3>
                        <p class="text-[10px] text-[#45A29E] font-black uppercase tracking-widest opacity-60">Personal and Professional Records</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $agent->name) }}" required
                            pattern="[a-zA-Z\s]+" title="Real Pattern: Only letters and spaces allowed"
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none">
                        @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Username</label>
                        <input type="text" name="username" value="{{ $agent->username }}" required
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none">
                        <div class="error-msg"></div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Primary Email</label>
                        <input type="email" name="email" value="{{ $agent->email }}" required
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none">
                        <div class="error-msg"></div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Contact Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone', $agent->phone) }}" required
                            pattern="[0-9+]+" title="Real Pattern: Only digits and + allowed"
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none">
                        @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Residential/Office Address</label>
                    <textarea name="address" rows="3" required
                        class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none resize-none">{{ $agent->address }}</textarea>
                    <div class="error-msg"></div>
                </div>
            </div>

            <!-- Password Card -->
            <div class="glass-panel p-8 rounded-[40px] border border-white/5 space-y-8 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-500/5 rounded-full blur-3xl"></div>
                
                <div class="flex items-center gap-4 border-b border-white/5 pb-6 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500">
                        <i class="bi bi-shield-lock text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-tight">Security Credentials</h3>
                        <p class="text-[10px] text-[#45A29E] font-black uppercase tracking-widest opacity-60">Leave blank to keep existing password</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">New Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none" minlength="6">
                        <div class="error-msg"></div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Confirm Update</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full bg-black/40 border border-white/10 rounded-2xl py-4 px-5 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all outline-none">
                        <div class="error-msg"></div>
                        @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Action -->
            <button type="submit" class="w-full py-6 rounded-3xl bg-gradient-to-r from-[#45A29E] to-[#64ffda] text-[#0B0C10] font-black text-sm uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(100,255,218,0.3)] hover:shadow-[0_25px_50px_-12px_rgba(100,255,218,0.4)] hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3">
                <i class="bi bi-cloud-arrow-up-fill text-xl"></i>
                Synchronize Profile Records
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarBox = document.getElementById('avatarBox');
                const initials = document.getElementById('initialsDisplay');
                
                // Update background and hide initials
                avatarBox.style.background = `url(${e.target.result}) center/cover no-repeat`;
                avatarBox.style.color = 'transparent';
                if (initials) initials.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
