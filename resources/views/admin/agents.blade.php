@extends('admin.layouts.admin')

@section('title', 'Fleet Personnel')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    
    <!-- Table Toolbar -->
    <div class="flex flex-col md:flex-row gap-8 items-center justify-between glass-panel p-8 rounded-3xl border border-white/5 premium-shadow">
        <div class="flex flex-col gap-2 w-full md:w-auto">
            <h3 class="text-2xl font-bold text-white tracking-tight">Active Fleet Agents</h3>
            <p class="text-xs text-[#45A29E] font-bold uppercase tracking-widest opacity-70">Node-Linked Personnel Management</p>
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
                    <tr class="text-xs uppercase tracking-widest text-[#45A29E] font-bold opacity-60 bg-white/[0.02]">
                        <th class="px-8 py-5 border-b border-white/5">Personnel Profile</th>
                        <th class="px-8 py-5 border-b border-white/5">Assigned Sector</th>
                        <th class="px-8 py-5 border-b border-white/5">Operational Status</th>
                        <th class="px-8 py-5 border-b border-white/5">Efficiency Node</th>
                        <th class="px-8 py-5 border-b border-white/5 text-center">Actions</th>
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
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#1F2833] to-[#0B0C10] border border-white/5 flex items-center justify-center text-xl font-bold text-white shadow-inner group-hover:border-[#66FCF1]/30 transition-all">
                                    {{ substr($agent['name'], 0, 1) }}
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-base font-bold text-white tracking-tight group-hover:text-[#66FCF1] transition-colors">{{ $agent['name'] }}</span>
                                    <span class="text-xs text-[#C5C6C7] opacity-60">{{ $agent['phone'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-[#C5C6C7] opacity-90">{{ $agent['sector'] }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold border" style="background-color: {{ $agent['color'] }}10; color: {{ $agent['color'] }}; border-color: {{ $agent['color'] }}30">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $agent['color'] }}"></span>
                                {{ $agent['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-2 w-36">
                                <div class="flex justify-between text-xs font-bold text-[#45A29E]">
                                    <span>Perf. Matrix</span>
                                    <span>{{ $agent['efficiency'] }}%</span>
                                </div>
                                <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden border border-white/10">
                                    <div class="h-full bg-gradient-to-r from-[#45A29E] to-[#66FCF1] w-[{{ $agent['efficiency'] }}%]" style="width: {{ $agent['efficiency'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModal('editAgentModal')" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#C5C6C7] hover:bg-blue-500/10 hover:text-blue-400 transition-all border border-transparent hover:border-blue-500/20 text-lg"><i class="bi bi-pencil-square"></i></button>
                                <button onclick="openModal('deleteAgentModal')" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#C5C6C7] hover:bg-red-500/10 hover:text-red-400 transition-all border border-transparent hover:border-red-500/20 text-lg"><i class="bi bi-trash3"></i></button>
                                <button class="w-10 h-10 rounded-xl flex items-center justify-center text-[#C5C6C7] hover:bg-[#66FCF1]/10 hover:text-[#66FCF1] transition-all border border-transparent hover:border-[#66FCF1]/20 text-lg"><i class="bi bi-three-dots"></i></button>
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

<!-- Edit Agent Modal -->
<x-modal id="editAgentModal" title="Update Personnel Dossier">
    <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Full Legal Name</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all" value="John Smith">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Assigned Sector</label>
                <select class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#66FCF1]/40 transition-all appearance-none">
                    <option selected>Sector 1 (Downtown)</option>
                    <option>Sector 2 (Logistics)</option>
                    <option>Sector 4 (Industrial)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Communication Channel</label>
                <input type="email" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white focus:outline-none" value="j.smith@fleet.pro">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#45A29E] uppercase tracking-widest pl-1">Operational ID</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-4 text-sm text-white/50 focus:outline-none" value="PRO-9921" disabled>
            </div>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="button" onclick="closeModal('editAgentModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-3 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Update</button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-400 text-[#0B0C10] font-bold py-3 rounded-2xl shadow-lg hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] transition-all">Execute Update</button>
        </div>
    </form>
</x-modal>

<!-- Delete Agent Modal -->
<x-modal id="deleteAgentModal" title="Decommission Personnel">
    <div class="space-y-8 text-center">
        <div class="w-20 h-20 rounded-full bg-red-500/10 flex items-center justify-center mx-auto border border-red-500/20 text-red-500 text-3xl">
            <i class="bi bi-person-x"></i>
        </div>
        
        <div class="space-y-2">
            <h4 class="text-xl font-bold text-white">Decommission Agent?</h4>
            <p class="text-sm text-[#C5C6C7] opacity-70 px-4">This will permanently revoke operational clearance for <span class="text-white font-bold tracking-widest">JOHN SMITH</span> and purge their profile.</p>
        </div>

        <div class="flex gap-4">
            <button type="button" onclick="closeModal('deleteAgentModal')" class="flex-1 bg-white/5 text-[#C5C6C7] font-bold py-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">Abort Action</button>
            <button type="button" onclick="closeModal('deleteAgentModal')" class="flex-1 bg-red-500/80 hover:bg-red-500 text-white font-bold py-4 rounded-2xl shadow-[0_10px_20px_-5px_rgba(239,68,68,0.3)] transition-all">Confirm Decommission</button>
        </div>
    </div>
</x-modal>
@endsection
