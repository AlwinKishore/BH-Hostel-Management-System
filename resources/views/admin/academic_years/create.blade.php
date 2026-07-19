@extends('layouts.admin')

@section('header', 'Create Academic Year')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('academic-years.index') }}" class="hover:text-indigo-600 transition-colors">Academic Academic Yeares</a>
        <span>/</span>
        <span class="text-slate-800">New Registration</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Create New Academic Year</h3>
            <p class="text-sm text-slate-600 font-medium">Add a new academic batch to the system</p>
        </div>

        <form action="{{ route('academic-years.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="form-label-premium">Academic Year Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="form-input-premium" placeholder="e.g. Academic Year 2026-2028" value="{{ old('name') }}" required>
                    @error('name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="start_date" class="form-label-premium">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-input-premium" value="{{ old('start_date') }}" required>
                        @error('start_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_date" class="form-label-premium">End Date <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-input-premium" value="{{ old('end_date') }}" required>
                        @error('end_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" value="1" name="is_current" id="is_current" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ old('is_current') ? 'checked' : '' }}>
                    <label for="is_current" class="ml-3 text-sm font-bold text-slate-700">Set as Current Active Academic Year</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('academic-years.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Save Academic Year
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
