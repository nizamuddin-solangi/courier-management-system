@extends('admin.layouts.admin')

@section('title', 'Fleet Agents Roster')

@section('content')
<style>
    .search-bar-agent {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(102, 252, 241, 0.15);
        border-radius: 100px;
        color: white;
        padding: 12px 24px 12px 48px;
        width: 100%;
        max-width: 400px;
        transition: all 0.3s ease;
    }
    
    .search-bar-agent:focus {
        outline: none;
        border-color: rgba(102, 252, 241, 0.5);
        box-shadow: 0 0 20px rgba(102, 252, 241, 0.1);
        background: rgba(0, 0, 0, 0.5);
    }

    .roster-card {
        background: linear-gradient(180deg, rgba(31, 40, 51, 0.4) 0%, rgba(11, 12, 16, 0.7) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .roster-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #45A29E, transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .roster-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5);
        border-color: rgba(102, 252, 241, 0.2);
    }

    .roster-card:hover::before {
        opacity: 1;
    }

    .avatar-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(102, 252, 241, 0.1);
        border: 1px solid rgba(102, 252, 241, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #66FCF1;
        font-weight: 900;
    }

    .info-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11px;
        color: #C5C6C7;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        box-shadow: 0 0 10px currentColor;
    }

    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #C5C6C7;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        transition: all 0.2s;
    }

    .btn-action-icon:hover.edit {
        color: #3B82F6;
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.2);
    }

    .btn-action-icon:hover.delete {
        color: #EF4444;
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.2);
    }
</style>

<div class="max-w-[1400px] mx-auto pb-10">

    <!-- Header & Controls -->
    <div class="flex flex-col md:flex-row gap-6 justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">Active Roster <span class="text-xs ml-2 px-2 py-0.5 rounded bg-white/10 text-white align-middle">Beta</span></h2>
            <p class="text-[12px] text-[#45A29E] font-bold uppercase tracking-widest mt-1 opacity-70">Grid overview of fleet personnel</p>
        </div>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-auto">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-[#45A29E]"></i>
                <input type="text" class="search-bar-agent" placeholder="Search by name, ID or city...">
            </div>
            <a href="/admin/add_new_agent" class="bg-[#1F2833] hover:bg-[#0B0C10] border border-[#66FCF1]/30 hover:border-[#66FCF1] text-[#66FCF1] font-bold py-3 px-6 rounded-[100px] whitespace-nowrap transition-all shadow-[0_0_15px_rgba(102,252,241,0.1)] hover:shadow-[0_0_25px_rgba(102,252,241,0.3)]">
                <i class="bi bi-plus-lg mr-2"></i>New Agent
            </a>
        </div>
    </div>

    <!-- Agent Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($agents as $agent)
        <!-- Agent Card -->
        <div class="roster-card p-6 flex flex-col justify-between h-full">
            
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="avatar-placeholder overflow-hidden">
                        @if($agent->image)
                            <img src="{{ asset('uploads/' . $agent->image) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($agent->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg leading-tight">{{ $agent->name }}</h3>
                        <p class="text-[#45A29E] text-xs font-mono mt-1 opacity-80">{{ $agent->agent_code }}</p>
                    </div>
                </div>
                
                @php
                    $statusColor = $agent->is_active ? '#10B981' : '#EF4444';
                    $statusLabel = $agent->is_active ? 'Active' : 'Offline';
                @endphp
                <div class="flex items-center gap-2 px-3 py-1 rounded-full border" style="background-color: {{ $statusColor }}15; border-color: {{ $statusColor }}30; color: {{ $statusColor }};">
                    <div class="status-dot" style="background-color: {{ $statusColor }}; box-shadow: 0 0 10px {{ $statusColor }};"></div>
                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $statusLabel }}</span>
                </div>
            </div>

            <!-- Specs Grid -->
            <div class="space-y-3 mt-4 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-[#C5C6C7] opacity-60"><i class="bi bi-envelope mr-2"></i>Email</span>
                    <span class="text-white truncate max-w-[150px]" title="{{ $agent->email }}">{{ $agent->email }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-[#C5C6C7] opacity-60"><i class="bi bi-telephone mr-2"></i>Contact</span>
                    <span class="text-white">{{ $agent->phone }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-[#C5C6C7] opacity-60"><i class="bi bi-building mr-2"></i>Branch</span>
                    <span class="text-white font-medium">{{ $agent->branch_name }}</span>
                </div>
                
                <!-- Route Indicator -->
                <div class="mt-4 p-3 rounded-xl bg-black/20 border border-white/5 flex items-center justify-between">
                    <div class="text-center w-5/12">
                        <p class="text-[9px] text-[#45A29E] uppercase font-bold tracking-wider mb-1">Origin</p>
                        <p class="text-white text-xs font-bold truncate">{{ $agent->from_city }}</p>
                    </div>
                    <div class="w-2/12 flex justify-center text-[#66FCF1] opacity-50">
                        <i class="bi bi-arrow-right-short text-xl"></i>
                    </div>
                    <div class="text-center w-5/12">
                        <p class="text-[9px] text-[#45A29E] uppercase font-bold tracking-wider mb-1">Destination</p>
                        <p class="text-white text-xs font-bold truncate">{{ $agent->to_city }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-white/5">
                <div class="text-[#45A29E] text-xs font-bold opacity-60">
                    <i class="bi bi-person-badge mr-1"></i> {{ $agent->username }}
                </div>
                <div class="flex gap-2">
                    <a href="{{ url('/admin/update_agent/'.$agent->id) }}" class="btn-action-icon edit" title="Edit Agent">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="{{ url('/admin/delete_agent/'.$agent->id) }}" class="btn-action-icon delete" title="Decommission" onclick="return confirm('Are you sure you want to permanently delete this agent record?');">
                        <i class="bi bi-trash3"></i>
                    </a>
                </div>
            </div>
            
        </div>
        @endforeach
        
    </div>

</div>
@endsection
