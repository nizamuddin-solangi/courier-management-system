@extends('admin.layouts.admin')

@section('title', 'Fleet Personnel')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Table Toolbar -->
    <div class="flex flex-col md:flex-row gap-6 items-center justify-between glass-panel p-6 rounded-3xl border border-white/5 premium-shadow">
        <div class="flex flex-col gap-1 w-full md:w-auto">
            <h3 class="text-xl font-bold text-white tracking-tight">Active Fleet Agents</h3>
            <p class="text-[10px] text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Node-Linked Personnel Management</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
            <!-- Search -->
            <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#C5C6C7]/30 group-focus-within:text-[#66FCF1] transition-colors">
                    <i class="bi bi-search text-sm"></i>
                </div>
                <input type="text" 
                    id="agentSearch" 
                    class="w-full bg-black/20 border border-white/10 rounded-xl py-2.5 pl-11 pr-4 text-sm text-white placeholder-[#C5C6C7]/30 focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all"
                    placeholder="Search by name, ID, or sector...">
            </div>

            <!-- Add Button -->
            <button onclick="openModal('addAgentModal')" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold px-6 py-2.5 rounded-xl shadow-[0_10px_20px_-5px_rgba(102,252,241,0.2)] hover:shadow-[0_15px_30px_-5px_rgba(102,252,241,0.4)] hover:-translate-y-0.5 transition-all duration-300">
                <i class="bi bi-plus-lg"></i>
                <span>Enlist New Agent</span>
            </button>
        </div>
    </div>

    <!-- Agents Grid / Table -->
    <div class="glass-panel overflow-hidden rounded-[40px] border border-white/5 premium-shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="text-[10px] uppercase tracking-widest text-[#45A29E] font-bold opacity-60 bg-white/[0.02]">
                        <th class="px-8 py-6 border-b border-white/5">Personnel Profile</th>
                        <th class="px-8 py-6 border-b border-white/5">Assigned Sector</th>
                        <th class="px-8 py-6 border-b border-white/5">Operational Status</th>
                        <th class="px-8 py-6 border-b border-white/5">Efficiency Node</th>
                        <th class="px-8 py-6 border-b border-white/5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @php
                        $agents = [
                            ['name' => 'John Smith', 'email' => 'j.smith@fleet.pro', 'phone' => '+1 (555) 012-9842', 'sector' => 'Downtown Core (Sector 1)', 'status' => 'Active', 'color' => '#66FCF1', 'efficiency' => 98],
                            ['name' => 'Sarah Johnson', 'email' => 's.johnson@fleet.pro', 'phone' => '+1 (555) 012-7721', 'sector' => 'Industrial Heights (Sector 4)', 'status' => 'Active', 'color' => '#66FCF1', 'efficiency' => 96],
                            ['name' => 'Michael Chen', 'email' => 'm.chen@fleet.pro', 'phone' => '+1 (555) 012-4432', 'sector' => 'Residential West (Sector 7)', 'status' => 'Offline', 'color' => '#FF4B5C', 'efficiency' => 92],
                            ['name' => 'Elena Rodriguez', 'email' => 'e.rodriguez@fleet.pro', 'phone' => '+1 (555) 012-1109', 'sector' => 'Tech-Village Node (Sector 2)', 'status' => 'On-Leave', 'color' => '#FF9F43', 'efficiency' => 95],
                        ];
                    @endphp

                    @foreach($agents as $agent)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#1F2833] to-[#0B0C10] border border-white/5 flex items-center justify-center text-lg font-bold text-white shadow-inner group-hover:border-[#66FCF1]/30 transition-all">
                                    {{ substr($agent['name'], 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-white tracking-tight group-hover:text-[#66FCF1] transition-colors">{{ $agent['name'] }}</span>
                                    <span class="text-[10px] text-[#C5C6C7] opacity-50">{{ $agent['phone'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-[#C5C6C7] opacity-80">{{ $agent['sector'] }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold border" style="background-color: {{ $agent['color'] }}10; color: {{ $agent['color'] }}; border-color: {{ $agent['color'] }}30">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $agent['color'] }}"></span>
                                {{ $agent['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1 w-32">
                                <div class="flex justify-between text-[10px] font-bold text-[#45A29E]">
                                    <span>Perf. Matrix</span>
                                    <span>{{ $agent['efficiency'] }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden border border-white/10">
                                    <div class="h-full bg-gradient-to-r from-[#45A29E] to-[#66FCF1] w-[{{ $agent['efficiency'] }}%]" style="width: {{ $agent['efficiency'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-2">
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-blue-500/10 hover:text-blue-400 transition-all border border-transparent hover:border-blue-500/20"><i class="bi bi-pencil-square"></i></button>
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-red-500/10 hover:text-red-400 transition-all border border-transparent hover:border-red-500/20"><i class="bi bi-trash3"></i></button>
                                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C5C6C7] hover:bg-[#66FCF1]/10 hover:text-[#66FCF1] transition-all border border-transparent hover:border-[#66FCF1]/20"><i class="bi bi-three-dots"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Agent Modal -->
<x-modal id="addAgentModal" title="Personnel Enlistment">
    <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Full Legal Name</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all" placeholder="Enter name...">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Primary Node/Sector</label>
                <select class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-[#C5C6C7] focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all appearance-none">
                    <option>Sector 1 (Downtown)</option>
                    <option>Sector 2 (Logistics)</option>
                    <option>Sector 4 (Industrial)</option>
                </select>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Contact Intelligence (Email)</label>
            <input type="email" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all" placeholder="agent@fleet.pro">
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Operational ID Prefix</label>
            <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all" placeholder="PRO-XXXX">
        </div>

        <div class="flex gap-4 pt-4">
            <button type="button" onclick="closeModal('addAgentModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-3 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Cancel Scan</button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-[#45A29E] to-[#66FCF1] text-[#0B0C10] font-bold py-3 rounded-2xl shadow-lg hover:shadow-[0_0_20px_rgba(102,252,241,0.3)] transition-all">Confirm Enlistment</button>
        </div>
    </form>
</x-modal>
@endsection
