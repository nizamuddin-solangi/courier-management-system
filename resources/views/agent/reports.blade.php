@extends('agent.layouts.agent')

@section('title', 'Branch Analytics & Reports')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Branch <span class="text-[#64ffda]">Intelligence</span></h2>
            <p class="text-[#C5C6C7] opacity-60 mt-1">Generate performance reports and export branch data for terminal {{ $current_agent->agent_code ?? 'N/A' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
                Current Branch: {{ $current_agent->branch_name ?? 'Loading...' }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Date Wise Report -->
        <div class="glass-panel p-8 rounded-[32px] premium-shadow space-y-6 flex flex-col">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-2xl bg-[#64ffda]/10 flex items-center justify-center text-[#64ffda] shadow-[0_0_20px_rgba(100,255,218,0.1)]">
                    <i class="bi bi-calendar-range text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white tracking-tight">Temporal Analysis</h3>
                    <p class="text-xs text-[#45A29E] font-medium opacity-60">Date-wise shipment breakdown</p>
                </div>
            </div>

            <div class="flex-1 space-y-6 pt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Start Date</label>
                        <input type="date" class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">End Date</label>
                        <input type="date" class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-2 focus:ring-[#64ffda]/50 transition-all">
                    </div>
                </div>
                
                <div class="p-5 rounded-2xl bg-white/5 border border-white/5 space-y-3">
                    <h4 class="text-[10px] font-bold text-white uppercase tracking-widest opacity-60">Format Options</h4>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="fmt1" checked class="accent-[#64ffda]">
                            <span class="text-xs text-[#C5C6C7]">Excel (.xlsx)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="fmt1" class="accent-[#64ffda]">
                            <span class="text-xs text-[#C5C6C7]">PDF Summary</span>
                        </label>
                    </div>
                </div>
            </div>

            <button onclick="alert('Module Processing: Compiling branch performance data for download...');" class="w-full py-4 rounded-2xl bg-gradient-to-r from-[#45A29E] to-[#64ffda] text-[#0B0C10] font-black text-sm shadow-[0_10px_20px_-5px_rgba(100,255,218,0.2)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                <i class="bi bi-download"></i> Download Temporal Report
            </button>
        </div>

        <!-- City Wise Report -->
        <div class="glass-panel p-8 rounded-[32px] premium-shadow space-y-6 flex flex-col">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 shadow-[0_0_20px_rgba(168,85,247,0.1)]">
                    <i class="bi bi-geo-alt text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white tracking-tight">Geographic Density</h3>
                    <p class="text-xs text-[#45A29E] font-medium opacity-60">City-wise distribution metrics</p>
                </div>
            </div>

            <div class="flex-1 space-y-6 pt-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Target Region</label>
                    <select class="w-full bg-black/20 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:ring-2 focus:ring-purple-400/50 transition-all">
                        <option>All Branch Destinations</option>
                        <option>Lahore Delivery Route</option>
                        <option>Islamabad Delivery Route</option>
                        <option>Quetta Delivery Route</option>
                        <option>Peshawar Delivery Route</option>
                    </select>
                </div>

                <div class="p-5 rounded-2xl bg-white/5 border border-white/5 space-y-3">
                    <h4 class="text-[10px] font-bold text-white uppercase tracking-widest opacity-60">Insight Depth</h4>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="accent-purple-400">
                            <span class="text-xs text-[#C5C6C7]">Include Revenue</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="accent-purple-400">
                            <span class="text-xs text-[#C5C6C7]">Volume Trends</span>
                        </label>
                    </div>
                </div>
            </div>

            <button onclick="alert('Export Initialized: Compiling geographic metrics for {{ $current_agent->branch_name }}...')" class="w-full py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-500 text-white font-black text-sm shadow-[0_10px_20px_-5px_rgba(139,92,246,0.3)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export Geographic Data
            </button>
        </div>
    </div>
</div>
@endsection
