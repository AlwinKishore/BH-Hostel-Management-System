@extends('layouts.admin')

@section('header', 'Add Student Remark')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('remarks.index') }}" class="hover:text-indigo-600 transition-colors">Remarks</a>
        <span>/</span>
        <span class="text-slate-800">New Remark</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Log New Remark</h3>
            <p class="text-sm text-slate-600 font-medium">Record a note regarding student conduct or general comments</p>
        </div>

        <form action="{{ route('remarks.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="hosteller_id" class="form-label-premium">Hosteller</label>
                    <select name="hosteller_id" id="hosteller_id" class="form-input-premium" required>
                        <option value="">Select Hosteller</option>
                        @foreach($hostellers as $hosteller)
                            <option value="{{ $hosteller->id }}" {{ old('hosteller_id') == $hosteller->id ? 'selected' : '' }}>
                                {{ $hosteller->student_name }} (Hostel {{ $hosteller->hostel_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('hosteller_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="remarks" class="form-label-premium">Remark Details</label>
                    <textarea name="remarks" id="remarks" rows="5" class="form-input-premium" placeholder="Enter full details of the remark..." required>{{ old('remarks') }}</textarea>
                    @error('remarks') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('remarks.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel Operation
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Save Remark
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
