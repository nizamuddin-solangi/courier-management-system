@extends('admin.layouts.admin')

@section('title', 'Update Agent')

@section('content')

<style>
    .update-container {
        max-width: 900px;
        margin: 0 auto;
        padding-bottom: 3rem;
    }

    .glass-card {
        background: linear-gradient(135deg, rgba(31, 40, 51, 0.4) 0%, rgba(11, 12, 16, 0.6) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        color: #45A29E;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #66FCF1;
        box-shadow: 0 0 0 3px rgba(102, 252, 241, 0.1);
    }

    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .btn-update {
        background: #45A29E;
        color: #fff;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(69, 162, 158, 0.2);
    }

    .btn-update:hover {
        background: #66FCF1;
        color: #0B0C10;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(102, 252, 241, 0.3);
    }

    .section-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.05);
        margin: 2rem 0;
    }

    /* Minimal Cyber Toggle */
    .minimal-toggle {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        padding-top: 0.5rem;
    }
    .toggle-ring {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.2);
        position: relative;
        transition: all 0.3s ease;
    }
    .toggle-core {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #66FCF1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 10px #66FCF1;
    }
    .minimal-toggle input:checked + .toggle-ring {
        border-color: #66FCF1;
    }
    .minimal-toggle input:checked + .toggle-ring .toggle-core {
        transform: translate(-50%, -50%) scale(1);
    }

    .error-msg {
        color: #ff4d4d;
        font-size: 11px;
        font-weight: 600;
        margin-top: 5px;
        font-family: inherit;
    }

    .form-input:invalid:not(:placeholder-shown) {
        border-color: #ff4d4d;
    }
</style>

<div class="update-container">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">Update <span class="text-[#66FCF1]">Agent Profile</span></h2>
            <p class="text-[#C5C6C7] mt-1 opacity-70">Editing records for CID: <span class="text-[#66FCF1] font-mono font-bold">{{ $agent->agent_code }}</span></p>
        </div>
        <a href="/admin/show_agent" class="text-xs font-bold text-[#C5C6C7] hover:text-[#66FCF1] uppercase tracking-widest transition-colors">
            <i class="bi bi-arrow-left"></i> Roster
        </a>
    </div>

    <div class="form-notice">
        <i class="bi bi-info-circle-fill"></i>
        <p class="text-xs font-bold text-white uppercase tracking-widest">Notice: Please complete all required fields. Real-time validation is active to ensure data integrity.</p>
    </div>

    @if(session('success'))
    <div class="p-4 mb-8 rounded-2xl bg-[#10B981]/10 border border-[#10B981]/20 text-[#10B981] font-bold text-center">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 mb-8 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500 font-bold text-center">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ url('admin/execute_update_agent/'.$agent->id) }}" method="POST" class="glass-card" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
            <!-- Col 1 -->
            <div>
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $agent->name) }}" class="form-input" required
                           pattern="[a-zA-Z\s]+" title="Real Pattern: Only letters and spaces allowed">
                    @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $agent->email) }}" class="form-input" required>
                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $agent->phone) }}" class="form-input" required
                           pattern="[0-9+]+" title="Real Pattern: Only digits and + allowed">
                    @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username', $agent->username) }}" class="form-input" required>
                    <div class="error-msg"></div>
                    @error('username') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Update Password <span class="text-[#C5C6C7] opacity-50 lowercase text-[10px] tracking-normal">(leave blank to keep current)</span></label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" minlength="6">
                    <div class="error-msg"></div>
                    @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Col 2 -->
            <div>
                <div class="form-group">
                    <label class="form-label">Profile Image</label>
                    <div class="flex items-center gap-6 mt-2">
                        <div class="w-16 h-16 rounded-xl bg-black/40 border border-white/10 flex items-center justify-center overflow-hidden">
                            @if($agent->image)
                                <img src="{{ asset('uploads/' . $agent->image) }}" class="w-full h-full object-cover" id="updatePreview">
                            @else
                                <i class="bi bi-person text-2xl text-[#45A29E] opacity-40"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" class="form-input text-xs" accept="image/jpeg,image/png,image/webp" onchange="previewUpdate(this)">
                            <div class="error-msg"></div>
                            @error('image') <div class="error-msg">{{ $message }}</div> @enderror
                            <p class="text-[9px] text-[#45A29E] mt-2 font-bold uppercase opacity-50 italic">Upload to replace current image</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Assigned Branch</label>
                    <select name="branch_name" class="form-input cursor-pointer" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->name }}" {{ $agent->branch_name == $branch->name ? 'selected' : '' }}>
                                {{ $branch->name }} ({{ $branch->city }})
                            </option>
                        @endforeach
                    </select>
                    <div class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Home City</label>
                    <input type="text" name="city" value="{{ $agent->city }}" class="form-input" required>
                    <div class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Origin jurisdiction (From)</label>
                    <input type="text" name="from_city" value="{{ $agent->from_city }}" class="form-input" required>
                    <div class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Target jurisdiction (To)</label>
                    <input type="text" name="to_city" value="{{ $agent->to_city }}" class="form-input" required>
                    <div class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">System Access Status</label>
                    <label class="minimal-toggle mt-2">
                        <input type="checkbox" name="is_active" value="1" {{ $agent->is_active ? 'checked' : '' }} class="hidden">
                        <div class="toggle-ring"><div class="toggle-core"></div></div>
                        <span class="text-white text-sm font-bold uppercase tracking-widest ml-4">Account Authorized & Active</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="section-divider"></div>

        <div class="form-group">
            <label class="form-label">Residential Address</label>
            <input type="text" name="address" value="{{ $agent->address }}" class="form-input" required>
            <div class="error-msg"></div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="btn-update">
                Commit Changes
            </button>
        </div>

    </form>
</div>

<script>
    function previewUpdate(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('updatePreview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // If no image existed before, replace the icon with an img tag
                    const container = input.closest('.flex').querySelector('.w-16');
                    container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
