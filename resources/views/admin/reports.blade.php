@extends('admin.layouts.admin')

@section('title', 'Export Reports')

@section('content')

<style>
    .report-card {
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

    /* Convert date picker icon color */
    ::-webkit-calendar-picker-indicator {
        filter: invert(1);
        opacity: 0.5;
        cursor: pointer;
    }

    .btn-export {
        background: linear-gradient(135deg, #10B981, #059669);
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
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        justify-content: center;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4);
    }
</style>

<div class="max-w-[800px] mx-auto pb-10">
    
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tight">System <span class="text-[#66FCF1]">Reporting</span></h2>
        <p class="text-[#C5C6C7] mt-3 font-medium opacity-80">Export date-wise and city-wise bill reports for processing.</p>
    </div>

    <form action="{{ route('admin.reports.download') }}" method="GET" class="report-card">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-b border-white/5 pb-8">
            <div class="form-group mb-0">
                <label class="form-label">Extract Range Origin</label>
                <input type="date" name="start_date" class="form-input">
                <p class="text-xs text-[#C5C6C7] opacity-50 mt-2">Leave blank to start from beginning of records</p>
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Extract Range Terminus</label>
                <input type="date" name="end_date" class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">City Node Filter</label>
            <input type="text" name="city" class="form-input" placeholder="e.g. New York">
            <p class="text-xs text-[#C5C6C7] opacity-50 mt-2">Filter logs strictly where the shipment origin or destination includes this node.</p>
        </div>

        <div class="mt-12">
            <button type="submit" class="btn-export">
                <i class="bi bi-file-earmark-excel-fill text-xl"></i> Complete CSV Extraction Pipeline
            </button>
        </div>

    </form>
</div>

@endsection
