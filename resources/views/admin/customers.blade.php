@extends('admin.layouts.admin')

@section('title', 'Manage Customers')

@section('content')

<style>
    .glass-card {
        background: linear-gradient(135deg, rgba(31, 40, 51, 0.4) 0%, rgba(11, 12, 16, 0.6) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        overflow: hidden;
    }

    .search-input {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        color: #fff;
        font-size: 0.875rem;
        width: 100%;
        max-width: 300px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #66FCF1;
        box-shadow: 0 0 0 3px rgba(102, 252, 241, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.3);
    }

    .customer-table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }

    .customer-table th {
        padding: 1rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #45A29E;
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .customer-table td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: #C5C6C7;
        font-weight: 500;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
    }

    .customer-table tr:last-child td {
        border-bottom: none;
    }

    .customer-table tr:hover td {
        background: rgba(255, 255, 255, 0.02);
        color: #fff;
    }
</style>

<div class="space-y-8 animate-fade-in w-full pb-10">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">Customer <span class="text-[#66FCF1]">Registry</span></h2>
            <p class="text-[#C5C6C7] mt-1 opacity-70">Dynamically generated from global consignment data</p>
        </div>
    </div>

    <div class="glass-card">
        
        <!-- Toolbar -->
        <div class="p-6 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="text-white font-bold text-lg"><i class="bi bi-people text-[#66FCF1] mr-2"></i> Address Book</h3>
            
            <form action="{{ route('admin.customers') }}" method="GET" class="relative w-full md:w-auto">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" value="{{ $search }}" class="search-input" placeholder="Search entity or phone...">
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Corporate/Personal Entity</th>
                        <th>Contact Designation</th>
                        <th>Primary Node (City)</th>
                        <th>Recorded Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="customer-table-body">
                    @include('admin.partials.customer_rows')
                </tbody>
            </table>
        </div>

        <!-- Remove standard pagination div since it's now in the partial -->
    </div>
</div>

<script>
const tbody = document.getElementById('customer-table-body');

function fetchCustomers(url) {
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        tbody.innerHTML = html;
    });
}

document.querySelector('input[name="search"]').addEventListener('input', function(e) {
    const search = e.target.value;
    clearTimeout(this.searchTimeout);
    this.searchTimeout = setTimeout(() => {
        fetchCustomers(`{{ route('admin.customers') }}?search=${search}`);
    }, 300);
});

tbody.addEventListener('click', function(e) {
    const link = e.target.closest('.pagination a');
    if (link) {
        e.preventDefault();
        fetchCustomers(link.href);
    }
});
</script>

@endsection
