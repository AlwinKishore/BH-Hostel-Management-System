@extends('layouts.admin')

@section('header', 'Edit Academic Year')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('years.index') }}" class="hover:text-indigo-600 transition-colors">Academic Years</a>
        <span>/</span>
        <span class="text-slate-800">Edit Year</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Year Details</h3>
            <p class="text-sm text-slate-600 font-medium">Update the academic year properties</p>
        </div>

        <form action="{{ route('years.update', $year) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="year_name" class="form-label-premium">Year Designation</label>
                    <input type="text" name="year_name" id="year_name" class="form-input-premium" placeholder="e.g. 1st Year" value="{{ old('year_name', $year->year_name) }}" required>
                    @error('year_name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" name="is_active" id="is_active" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ old('is_active', $year->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-3 text-sm font-bold text-slate-700">Year is Active</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('years.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel Operation
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Year
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
