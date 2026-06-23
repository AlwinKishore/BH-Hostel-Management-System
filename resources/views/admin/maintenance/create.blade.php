@extends('layouts.admin')

@section('header', 'Log Maintenance Incident')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('maintenance.index') }}" class="hover:text-indigo-600 transition-colors">Maintenance</a>
        <span>/</span>
        <span class="text-slate-800">New Incident Log</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Post Request</h3>
            <p class="text-sm text-slate-600 font-medium">Record a new facility issue or maintenance requirement</p>
        </div>

        <form action="{{ route('maintenance.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label for="title" class="form-label-premium">Issue Identifier / Title</label>
                    <input type="text" name="title" id="title" class="form-input-premium" placeholder="e.g. Broken Fan in Room 202, Water Leakage" required>
                    @error('title') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="room_id" class="form-label-premium">Affected Station / Room</label>
                    <div class="relative">
                        <select name="room_id" id="room_id" class="form-input-premium appearance-none" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_number }} ({{ $room->building->name }})</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="student_id" class="form-label-premium">Reporting Originator (Optional)</label>
                    <div class="relative">
                        <select name="student_id" id="student_id" class="form-input-premium appearance-none">
                            <option value="">System Generated / Internal</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="form-label-premium">Urgency Classification</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['low' => ['bg-slate-100', 'text-slate-600', 'fas fa-info-circle'], 
                                  'medium' => ['bg-sky-100', 'text-sky-600', 'fas fa-check-circle'], 
                                  'high' => ['bg-orange-100', 'text-orange-600', 'fas fa-exclamation-triangle'], 
                                  'urgent' => ['bg-rose-100', 'text-rose-600', 'fas fa-bolt']] as $val => $meta)
                        <label class="cursor-pointer group">
                            <input type="radio" name="priority" value="{{ $val }}" class="hidden peer" {{ $val == 'medium' ? 'checked' : '' }}>
                            <div class="p-4 rounded-2xl border-2 border-transparent bg-white shadow-sm flex flex-col items-center justify-center transition-all peer-checked:border-slate-800 peer-checked:shadow-lg group-hover:bg-slate-50">
                                <div class="w-10 h-10 rounded-xl {{ $meta[0] }} {{ $meta[1] }} flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                                    <i class="{{ $meta[2] }}"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $val }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:col-span-2">
                    <div>
                        <label for="scheduled_date" class="form-label-premium">Logistics Schedule Date</label>
                        <input type="date" name="scheduled_date" id="scheduled_date" class="form-input-premium">
                    </div>
                    <div>
                        <label for="completion_date" class="form-label-premium">Target Completion</label>
                        <input type="date" name="completion_date" id="completion_date" class="form-input-premium">
                    </div>
                    <div>
                        <label for="cost" class="form-label-premium">Estimated Costs</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                            <input type="number" step="0.01" name="cost" id="cost" class="form-input-premium pl-12" value="0.00">
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="form-label-premium">Detailed Logistics / Description</label>
                    <textarea name="description" id="description" rows="4" class="form-input-premium resize-none" placeholder="Provide technical details, specific location details, or urgency context..." required></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('maintenance.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Cancel Operation
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-bolt mr-2 opacity-70"></i> Post Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
