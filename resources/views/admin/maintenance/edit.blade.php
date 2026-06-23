@extends('layouts.admin')

@section('header', 'Update Maintenance Logistics')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('maintenance.index') }}" class="hover:text-indigo-600 transition-colors">Maintenance</a>
        <span>/</span>
        <span class="text-slate-800">Operational Update</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10 flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Request #{{ $maintenanceRequest->id }}</h3>
                <p class="text-sm text-slate-600 font-medium">Update status, timeline, or repair documentation</p>
            </div>
            <div class="px-4 py-2 bg-indigo-50 rounded-2xl border border-indigo-100 flex items-center">
                <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse mr-3"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-indigo-700">Live Entry</span>
            </div>
        </div>

        <form action="{{ route('maintenance.update', $maintenanceRequest) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-3">
                    <label for="title" class="form-label-premium">Issue Identifier / Title</label>
                    <input type="text" name="title" id="title" class="form-input-premium" value="{{ $maintenanceRequest->title }}" required>
                </div>

                <div>
                    <label for="room_id" class="form-label-premium">Affected Station / Room</label>
                    <div class="relative">
                        <select name="room_id" id="room_id" class="form-input-premium appearance-none" required>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ $maintenanceRequest->room_id == $room->id ? 'selected' : '' }}>{{ $room->room_number }} ({{ $room->building->name }})</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="student_id" class="form-label-premium">Reporting Originator</label>
                    <div class="relative">
                        <select name="student_id" id="student_id" class="form-input-premium appearance-none">
                            <option value="">System Generated / Internal</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $maintenanceRequest->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="form-label-premium text-indigo-600">Urgency Classification</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['low' => ['bg-slate-100', 'text-slate-600', 'fas fa-info-circle'], 
                                  'medium' => ['bg-sky-100', 'text-sky-600', 'fas fa-check-circle'], 
                                  'high' => ['bg-orange-100', 'text-orange-600', 'fas fa-exclamation-triangle'], 
                                  'urgent' => ['bg-rose-100', 'text-rose-600', 'fas fa-bolt']] as $val => $meta)
                        <label class="cursor-pointer group">
                            <input type="radio" name="priority" value="{{ $val }}" class="hidden peer" {{ $maintenanceRequest->priority == $val ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-transparent bg-slate-50 flex flex-col items-center justify-center transition-all peer-checked:border-indigo-600 peer-checked:bg-white peer-checked:shadow-md group-hover:bg-slate-100">
                                <i class="{{ $meta[2] }} {{ $meta[1] }} text-base mb-1"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">{{ $val }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <input type="hidden" name="status" value="{{ $maintenanceRequest->status }}">

                <div>
                    <label for="cost" class="form-label-premium">Repair Costs (INR)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <input type="number" step="0.01" name="cost" id="cost" class="form-input-premium pl-12" value="{{ $maintenanceRequest->cost }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:col-span-3">
                    <div>
                        <label for="scheduled_date" class="form-label-premium">Logistics Schedule Date</label>
                        <input type="date" name="scheduled_date" id="scheduled_date" class="form-input-premium" value="{{ $maintenanceRequest->scheduled_date }}">
                    </div>
                    <div>
                        <label for="completion_date" class="form-label-premium">Target/Actual Completion</label>
                        <input type="date" name="completion_date" id="completion_date" class="form-input-premium" value="{{ $maintenanceRequest->completion_date }}">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label for="description" class="form-label-premium">Technical Documentation / Description</label>
                    <textarea name="description" id="description" rows="4" class="form-input-premium resize-none" required>{{ $maintenanceRequest->description }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('maintenance.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard Changes
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-sync-alt mr-2 opacity-70"></i> Update Entry
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
