@extends('admin.layouts.admin')

@section('title', 'SMS Gateway')

@section('content')

<style>
    .sms-card {
        background: linear-gradient(135deg, rgba(31, 40, 51, 0.4) 0%, rgba(11, 12, 16, 0.6) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 40px;
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

    .btn-send {
        background: linear-gradient(135deg, #FF9F43, #E67E22);
        color: #111;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(255, 159, 67, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        justify-content: center;
    }

    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(255, 159, 67, 0.4);
    }
</style>

<div class="max-w-[800px] mx-auto pb-10">
    
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tight">SMS <span class="text-[#FF9F43]">Dispatch Array</span></h2>
        <p class="text-[#C5C6C7] mt-3 font-medium opacity-80">Trigger simulated communication pipelines directly to receiver handsets.</p>
    </div>

    @if(session('success'))
    <div class="p-4 mb-8 rounded-2xl bg-[#10B981]/10 border border-[#10B981]/20 text-[#10B981] font-bold text-center">
        <i class="bi bi-chat-dots-fill mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.sms.send') }}" method="POST" class="sms-card">
        @csrf
        
        <div class="form-group mb-8">
            <label class="form-label">Target Consignment</label>
            <select name="courier_id" required class="form-input">
                <option value="" hidden>Search by Tracking ID or Receiver Name...</option>
                @foreach($couriers as $courier)
                    <option value="{{ $courier->id }}">
                        {{ $courier->tracking_number }} - {{ $courier->receiver_name }} ({{ $courier->receiver_phone }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-12">
            <label class="form-label">Notification Package Type</label>
            <select name="sms_type" required class="form-input text-[#FF9F43]">
                <option value="dispatch">Dispatch Alert (From - To routing)</option>
                <option value="delivery">Delivery Success Confirmation</option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn-send">
                <i class="bi bi-broadcast text-xl"></i> Transmit Packet
            </button>
            <p class="text-center text-xs mt-4 text-[#C5C6C7] opacity-40 italic">Note: Executing this will fire a payload to the backend simulation logs.</p>
        </div>

    </form>
</div>

@endsection
