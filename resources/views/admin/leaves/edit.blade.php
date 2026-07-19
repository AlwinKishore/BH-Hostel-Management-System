@extends('layouts.admin')

@section('header', 'Edit Leave Request')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('leaves.index') }}" class="hover:text-indigo-600 transition-colors">Leave Requests</a>
        <span>/</span>
        <span class="text-slate-800">Edit Leave</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Leave Request</h3>
            <p class="text-sm text-slate-600 font-medium">Update leave details and approval status</p>
        </div>

        <form action="{{ route('leaves.update', $leave) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <input type="hidden" name="hosteller_id" value="{{ $leave->hosteller_id }}">
                
                <div>
                    <label class="form-label-premium">Hosteller Name</label>
                    <input type="text" class="form-input-premium bg-slate-50 text-slate-500 cursor-not-allowed" value="{{ $leave->hosteller->student_name }} (Hostel {{ $leave->hosteller->hostel_no }})" readonly>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label-premium">Room No</label>
                        <input type="text" class="form-input-premium bg-slate-50 text-slate-500 cursor-not-allowed" value="{{ $leave->hosteller->room->room_no ?? 'N/A' }}" readonly>
                    </div>
                    <div>
                        <label class="form-label-premium">Department No</label>
                        <input type="text" class="form-input-premium bg-slate-50 text-slate-500 cursor-not-allowed" value="{{ $leave->hosteller->dno ?? 'N/A' }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="form-label-premium">Start Date <span class="text-rose-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-input-premium" value="{{ old('start_date', $leave->start_date) }}" required>
                        @error('start_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_date" class="form-label-premium">End Date <span class="text-rose-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-input-premium" value="{{ old('end_date', $leave->end_date) }}" required>
                        @error('end_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="reason" class="form-label-premium">Reason <span class="text-rose-500">*</span></label>
                    <textarea name="reason" id="reason" rows="3" class="form-input-premium" required>{{ old('reason', $leave->reason) }}</textarea>
                    @error('reason') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('leaves.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Leave
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
