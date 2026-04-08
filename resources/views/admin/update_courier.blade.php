@extends('admin.layouts.admin')

@section('title', 'Update Courier')

@section('content')

{{-- Use the project's premium styling --}}
<style>
    .form-section {
        background: rgba(31, 40, 51, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
    }

    .form-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #45A29E;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        color: #66FCF1;
        opacity: 0.5;
        font-size: 16px;
    }

    .form-input {
        width: 100%;
        background: #0B0C10;
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 12px 16px 12px 45px;
        font-size: 14px;
        color: #ffffff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .form-input:focus {
        border-color: rgba(102, 252, 241, 0.5);
        box-shadow: 0 0 0 3px rgba(102, 252, 241, 0.08);
    }

    .form-input::placeholder {
        color: rgba(197, 198, 199, 0.3);
    }

    select.form-input {
        appearance: none;
        padding-right: 40px;
    }

    .select-chevron {
        position: absolute;
        right: 16px;
        color: rgba(255, 255, 255, 0.3);
        pointer-events: none;
    }

    .btn-premium {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.2s;
        background: linear-gradient(135deg, #45A29E, #66FCF1);
        color: #0B0C10;
    }

    .btn-premium:hover {
        transform: translateY(-1px);
        box-shadow: 0 0 28px rgba(102, 252, 241, 0.35);
    }

    .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .badge-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(102, 252, 241, 0.1);
        border: 1px solid rgba(102, 252, 241, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #66FCF1;
        font-size: 14px;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:30px;">
        <div>
            <h2 style="color:#fff; font-size:26px; font-weight:800; margin:0;">Update Waybill</h2>
            <p style="color:#45A29E; font-size:13px; font-weight:500; margin:4px 0 0; opacity:0.6;">Modify shipment parameters and status</p>
        </div>
        <div style="display:flex; gap:12px;">
            <a href="/admin/couriers" style="
                padding:11px 20px; border-radius:12px; font-size:14px; font-weight:700;
                background:rgba(255,255,255,0.05); border:1.5px solid rgba(255,255,255,0.12);
                color:#C5C6C7; text-decoration:none; transition: all 0.2s;
            " onmouseenter="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff'"
               onmouseleave="this.style.background='rgba(255,255,255,0.05)';this.style.color='#C5C6C7'">
                Back to Ledger
            </a>
            <button type="submit" form="updateCourierForm" class="btn-premium">
                <i class="bi bi-arrow-repeat"></i> Update Shipment
            </button>
        </div>
    </div>

    @if(session('success'))
    <div style="padding: 16px; border-radius: 12px; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.2); color: #34d399; margin-bottom: 24px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Container -->
    <form id="updateCourierForm" action="{{ route('admin.execute_update_courier', $ship->id) }}" method="POST">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Logistics & Status Row -->
            <div class="form-section">
                <div class="section-title">
                    <div class="badge-icon"><i class="bi bi-ui-checks"></i></div>
                    Operational Control
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px;">
                    <div>
                        <label style="color:#C5C6C7; font-size:12px; margin-bottom:8px; display:block;">Tracking / Waybill No.</label>
                        <input type="text" name="tracking_number" value="{{ $ship->tracking_number }}" readonly style="width:100%; border:1px solid #C5C6C7; padding:10px; border-radius:6px; background-color:#e9ecef;">
                    </div>
                    
                    <div>
                        <label style="color:#C5C6C7; font-size:12px; margin-bottom:8px; display:block;">Assigned Operator (Agent)</label>
                        <select name="agent_id" required style="width:100%; border:1px solid #C5C6C7; padding:10px; border-radius:6px;">
                            <option value="">Select Agent...</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $ship->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }} ({{ $agent->city }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="color:#C5C6C7; font-size:12px; margin-bottom:8px; display:block;">Estimated Delivery Date</label>
                        <input type="date" name="delivery_date" value="{{ $ship->delivery_date }}" required style="width:100%; border:1px solid #C5C6C7; padding:10px; border-radius:6px;">
                    </div>
                    
                    <div>
                        <label style="color:#C5C6C7; font-size:12px; margin-bottom:8px; display:block;">Estimated Delivery Time</label>
                        <input type="time" name="delivery_time" value="{{ \Carbon\Carbon::parse($ship->delivery_time)->format('H:i') }}" required style="width:100%; border:1px solid #C5C6C7; padding:10px; border-radius:6px;">
                    </div>

                    <div>
                        <label class="form-label">Current Status</label>
                        <div class="input-group">
                            <i class="bi bi-activity input-icon"></i>
                            <select name="status" required class="form-input" style="color: #66FCF1; font-weight: 700; border-color: rgba(102,252,241,0.2);">
                                <option value="pending" @selected($ship->status == 'pending')>Pending</option>
                                <option value="in_transit" @selected($ship->status == 'in_transit')>In-Transit</option>
                                <option value="delivered" @selected($ship->status == 'delivered')>Delivered</option>
                                <option value="cancelled" @selected($ship->status == 'cancelled')>Cancelled</option>
                            </select>
                            <i class="bi bi-chevron-down select-chevron" style="color: #66FCF1;"></i>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Parcel Type</label>
                        <div class="input-group">
                            <i class="bi bi-box-seam input-icon"></i>
                            <select name="parcel_type" required class="form-input">
                                <option value="document" @selected($ship->parcel_type == 'document')>Document</option>
                                <option value="box" @selected($ship->parcel_type == 'box')>Box</option>
                                <option value="fragile" @selected($ship->parcel_type == 'fragile')>Fragile</option>
                            </select>
                            <i class="bi bi-chevron-down select-chevron"></i>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Weight (KG)</label>
                        <div class="input-group">
                            <i class="bi bi-speedometer2 input-icon"></i>
                            <input type="number" step="0.01" name="weight" required class="form-input" value="{{ $ship->weight }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Sender -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="badge-icon"><i class="bi bi-person-up"></i></div>
                        Sender Intelligence
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" name="sender_name" required class="form-input" value="{{ $ship->sender_name }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Contact Number</label>
                            <div class="input-group">
                                <i class="bi bi-telephone input-icon"></i>
                                <input type="text" name="sender_phone" required class="form-input" value="{{ $ship->sender_phone }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Origin Node (City)</label>
                            <div class="input-group">
                                <i class="bi bi-buildings input-icon"></i>
                                <input type="text" name="from_city" required class="form-input" value="{{ $ship->from_city }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Pickup Address</label>
                            <div class="input-group">
                                <i class="bi bi-geo-alt input-icon" style="top: 15px;"></i>
                                <textarea name="sender_address" required rows="3" class="form-input" style="padding-top: 12px;">{{ $ship->sender_address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receiver -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="badge-icon" style="color: #FF9F43; background: rgba(255,159,67,0.1); border-color: rgba(255,159,67,0.2);">
                            <i class="bi bi-person-down"></i>
                        </div>
                        Receiver Intelligence
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <i class="bi bi-person input-icon" style="color: #FF9F43;"></i>
                                <input type="text" name="receiver_name" required class="form-input" value="{{ $ship->receiver_name }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Contact Number</label>
                            <div class="input-group">
                                <i class="bi bi-telephone input-icon" style="color: #FF9F43;"></i>
                                <input type="text" name="receiver_phone" required class="form-input" value="{{ $ship->receiver_phone }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Target Node (City)</label>
                            <div class="input-group">
                                <i class="bi bi-buildings input-icon" style="color: #FF9F43;"></i>
                                <input type="text" name="to_city" required class="form-input" value="{{ $ship->to_city }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Delivery Address</label>
                            <div class="input-group">
                                <i class="bi bi-geo-alt input-icon" style="top: 15px; color: #FF9F43;"></i>
                                <textarea name="receiver_address" required rows="3" class="form-input" style="padding-top: 12px;">{{ $ship->receiver_address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="form-section" style="background: linear-gradient(135deg, rgba(31,40,51,0.95), rgba(11,12,16,0.95));">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div class="section-title" style="margin-bottom: 4px;">
                            <div class="badge-icon" style="color:#66FCF1; background:rgba(102,252,241,0.1); border-color:rgba(102,252,241,0.2);">
                                <i class="bi bi-receipt-cutoff"></i>
                            </div>
                            Billing Settlement
                        </div>
                        <p style="color:#45A29E; font-size:12px; margin-left: 44px;">Update tariff for this specific shipment</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="form-label" style="margin: 0;">Total Amount (PKR)</span>
                        <div class="input-group" style="width: 200px;">
                            <span style="position: absolute; left: 16px; color: #66FCF1; font-weight: 800; font-size: 16px;">Rs.</span>
                            <input type="number" step="0.01" name="price" required class="form-input" 
                                   style="padding-left: 50px; font-size: 20px; font-weight: 800; color: #66FCF1; border-color: rgba(102,252,241,0.3); text-align: right;" 
                                   value="{{ $ship->price }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
