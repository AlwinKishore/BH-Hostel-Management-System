@extends('layouts.admin')

@section('header', 'Edit Student Remark')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('remarks.index') }}" class="hover:text-indigo-600 transition-colors">Remarks</a>
        <span>/</span>
        <span class="text-slate-800">Edit Remark</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Student Remark</h3>
            <p class="text-sm text-slate-600 font-medium">Update the details of a recorded note</p>
        </div>

        <form action="{{ route('remarks.update', $remark) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="hosteller_id" class="form-label-premium">Hosteller <span class="text-rose-500">*</span></label>
                    <select name="hosteller_id" id="hosteller_id" class="form-input-premium" required>
                        <option value="">Select Hosteller</option>
                        @foreach($hostellers as $hosteller)
                            <option value="{{ $hosteller->id }}" {{ old('hosteller_id', $remark->hosteller_id) == $hosteller->id ? 'selected' : '' }}>
                                {{ $hosteller->student_name }} (Hostel {{ $hosteller->hostel_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('hosteller_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="form-label-premium">Room No</label>
                        <input type="text" name="start_date" id="start_date" class="form-input-premium" value="{{ $hosteller->room->room_no }}" disabled>
                    </div>
                    <div>
                        <label for="end_date" class="form-label-premium">Department No</label>
                        <input type="text" name="end_date" id="end_date" class="form-input-premium" value="{{ $hosteller->dno }}" disabled>
                    </div>
                </div>

                <div>
                    <label for="remarks" class="form-label-premium">Remark Details <span class="text-rose-500">*</span></label>
                    <textarea name="remarks" id="remarks" rows="5" class="form-input-premium" required>{{ old('remarks', $remark->remarks) }}</textarea>
                    @error('remarks') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('remarks.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Remark
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
