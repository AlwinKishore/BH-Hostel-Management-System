@extends('layouts.admin')

@section('header', 'System Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
    <!-- Student Analytics -->
    <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500">
        <div class="flex justify-between items-start mb-6">
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <div class="text-right">
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-500 transition-colors">Active Census</span>
                <h4 class="text-4xl font-black text-slate-800 group-hover:text-white mt-1 transition-colors">{{ $stats['total_students'] }}</h4>
            </div>
        </div>
        <div class="flex items-center text-[10px] font-bold text-emerald-600 group-hover:text-emerald-400 transition-colors">
            <i class="fas fa-arrow-trend-up mr-2"></i>
            <span>+2.4% FROM LAST MONTH</span>
        </div>
    </div>

    <!-- Inventory Analytics -->
    <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500">
        <div class="flex justify-between items-start mb-6">
            <div class="w-14 h-14 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                <i class="fas fa-door-open text-2xl"></i>
            </div>
            <div class="text-right">
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-500 transition-colors">Room Inventory</span>
                <h4 class="text-4xl font-black text-slate-800 group-hover:text-white mt-1 transition-colors">{{ $stats['total_rooms'] }}</h4>
            </div>
        </div>
        <div class="flex items-center text-[10px] font-bold text-sky-600 group-hover:text-sky-400 transition-colors">
            <span class="opacity-70 mr-2 uppercase">Availability:</span>
            <span class="font-black">{{ $stats['vacant_rooms'] }} VACANT UNITS</span>
        </div>
    </div>

    <!-- Attendance Analytics -->
    <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500">
        <div class="flex justify-between items-start mb-6">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div class="text-right">
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-500 transition-colors">Today's Attendance</span>
                <h4 class="text-4xl font-black text-slate-800 group-hover:text-white mt-1 transition-colors">{{ $stats['todays_attendance'] }}</h4>
            </div>
        </div>
        <div class="flex items-center text-[10px] font-bold text-slate-400 group-hover:text-slate-500 transition-colors italic">
            <i class="fas fa-clock mr-2"></i>
            <span>UPDATING IN REAL-TIME</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Operational Alerts -->
    <div class="glass-card p-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-lg font-black text-slate-800">Operational Alerts</h4>
                <p class="text-xs text-slate-600 font-bold uppercase tracking-widest mt-1">Hostel Management</p>
            </div>
            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                <i class="fas fa-bell"></i>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center p-5 bg-rose-50 rounded-3xl border border-rose-100/50 group cursor-pointer hover:shadow-lg transition-all">
                <div class="w-12 h-12 bg-rose-500 rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg shadow-rose-500/20">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <div>
                    <div class="text-sm font-black text-rose-800">Pending Leaves</div>
                    <div class="text-xs text-rose-600 font-bold uppercase tracking-tight mt-0.5">{{ $stats['leaves_pending'] }} Requests require approval</div>
                </div>
                <i class="fas fa-chevron-right ml-auto text-rose-300 group-hover:translate-x-1 transition-transform"></i>
            </div>

            <div class="flex items-center p-5 bg-indigo-50 rounded-3xl border border-indigo-100/50 group cursor-pointer hover:shadow-lg transition-all">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg shadow-indigo-600/20">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <div class="text-sm font-black text-indigo-800">Active Batches</div>
                    <div class="text-xs text-indigo-600 font-bold uppercase tracking-tight mt-0.5">{{ $stats['active_batches'] }} Batches currently active</div>
                </div>
                <i class="fas fa-chevron-right ml-auto text-indigo-300 group-hover:translate-x-1 transition-transform"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass-card p-8">
        <h4 class="text-lg font-black text-slate-800 mb-8">Navigation Quick-Links</h4>
        <div class="grid grid-cols-2 gap-4">
            <a href="#" class="flex flex-col items-center justify-center p-6 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-300 group">
                <i class="fas fa-user-plus text-xl mb-3 text-slate-400 group-hover:text-indigo-400"></i>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600 group-hover:text-white">New Resident</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-6 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-300 group">
                <i class="fas fa-layer-group text-xl mb-3 text-slate-400 group-hover:text-emerald-400"></i>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600 group-hover:text-white">New Batch</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-6 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-300 group">
                <i class="fas fa-calendar-check text-xl mb-3 text-slate-400 group-hover:text-sky-400"></i>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600 group-hover:text-white">Daily Roster</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-6 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-300 group">
                <i class="fas fa-bed text-xl mb-3 text-slate-400 group-hover:text-orange-400"></i>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600 group-hover:text-white">Manage Rooms</span>
            </a>
        </div>
    </div>
</div>
@endsection
