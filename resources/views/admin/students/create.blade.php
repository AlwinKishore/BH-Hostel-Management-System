@extends('layouts.admin')

@section('header', 'Register New Student')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('students.index') }}" class="hover:text-indigo-600 transition-colors">Students</a>
        <span>/</span>
        <span class="text-slate-800">New Registration</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Onboard New Resident</h3>
            <p class="text-sm text-slate-600 font-medium">Capture student particulars and initialize facility allocation</p>
        </div>

        <form action="{{ route('students.store') }}" method="POST" class="space-y-12">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Personal Info Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                            <i class="fas fa-user text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Personal Identification</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="student_name" class="form-label-premium">Student Full Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-input-premium" placeholder="e.g. Johnathan Doe" value="{{ old('student_name') }}" required>
                            @error('student_name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hostel_no" class="form-label-premium">Hostel Number</label>
                                <input type="number" name="hostel_no" id="hostel_no" class="form-input-premium" placeholder="e.g. 101" value="{{ old('hostel_no') }}" required>
                                @error('hostel_no') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="dno" class="form-label-premium">D.No</label>
                                <input type="text" name="dno" id="dno" class="form-input-premium" placeholder="e.g. D102" value="{{ old('dno') }}">
                                @error('dno') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="batch_id" class="form-label-premium">Batch</label>
                                <select name="batch_id" id="batch_id" class="form-input-premium appearance-none">
                                    <option value="">Select Batch</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->batch_name }}</option>
                                    @endforeach
                                </select>
                                @error('batch_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="year_id" class="form-label-premium">Academic Year</label>
                                <select name="year_id" id="year_id" class="form-input-premium appearance-none">
                                    <option value="">Select Year</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year->id }}" {{ old('year_id') == $year->id ? 'selected' : '' }}>{{ $year->year_name }}</option>
                                    @endforeach
                                </select>
                                @error('year_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Allocation Info Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-600/20">
                            <i class="fas fa-bed text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Facility Allocation</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="room_id" class="form-label-premium">Designated Residential Unit</label>
                            <div class="relative group">
                                <select name="room_id" id="room_id" class="form-input-premium appearance-none">
                                    <option value="">Select Room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Room {{ $room->room_no }} (Floor {{ $room->floor }}) — {{ max(0, $room->accommodation - $room->hostellers_count) }} beds free
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-search-location text-xs"></i>
                                </div>
                            </div>
                            @error('room_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('students.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard Operation
                </a>
                <button type="submit" class="btn-premium px-12 py-4 shadow-xl shadow-indigo-600/20">
                    <i class="fas fa-user-plus mr-2 opacity-70"></i> Finish Registration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
