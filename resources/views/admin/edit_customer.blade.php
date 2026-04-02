@extends('admin.layouts.admin')

@section('title', 'Edit Customer')

@section('content')

<style>
    .glass-card {
        background: linear-gradient(135deg, rgba(31, 40, 51, 0.4) 0%, rgba(11, 12, 16, 0.6) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        padding: 40px;
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

    .btn-premium {
        background: linear-gradient(135deg, #45A29E 0%, #66FCF1 100%);
        color: #0B0C10;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 252, 241, 0.2);
    }
</style>

<div class="max-w-[800px] mx-auto pb-10">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">Edit <span class="text-[#66FCF1]">Customer Details</span></h2>
            <p class="text-[#C5C6C7] mt-1 opacity-70">Update the record in the secured customer database</p>
        </div>
        <a href="{{ route('admin.customers') }}" class="text-[#45A29E] hover:text-[#66FCF1] transition-colors font-bold text-sm">
            <i class="bi bi-arrow-left mr-2"></i> Back to Registry
        </a>
    </div>

    <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST" class="glass-card">
        @csrf
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Full Name / Entity</label>
                    <input type="text" name="name" value="{{ $customer->name }}" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Contact Number (Phone)</label>
                    <input type="text" name="phone" value="{{ $customer->phone }}" required class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Location (City)</label>
                <input type="text" name="city" value="{{ $customer->city }}" required class="form-input">
            </div>

            <div>
                <label class="form-label">Mailing / Business Address</label>
                <textarea name="address" rows="4" required class="form-input">{{ $customer->address }}</textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-premium w-full">
                    <i class="bi bi-shield-check mr-2"></i> Securely Update Customer Record
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
