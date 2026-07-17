@extends('layouts.admin')

@section('header', 'Edit Batch')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('batches.index') }}" class="hover:text-indigo-600 transition-colors">Academic Batches</a>
        <span>/</span>
        <span class="text-slate-800">Edit Batch</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Batch Details</h3>
            <p class="text-sm text-slate-600 font-medium">Update the academic batch properties</p>
        </div>

        <form action="{{ route('batches.update', $batch) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="batch_name" class="form-label-premium">Batch Name</label>
                    <input type="text" name="batch_name" id="batch_name" class="form-input-premium" placeholder="e.g. Batch 2026-2028" value="{{ old('batch_name', $batch->batch_name) }}" required>
                    @error('batch_name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="start_date" class="form-label-premium">Start Date (Optional)</label>
                        <input type="date" name="start_date" id="start_date" class="form-input-premium" value="{{ old('start_date', $batch->start_date) }}">
                        @error('start_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_date" class="form-label-premium">End Date (Optional)</label>
                        <input type="date" name="end_date" id="end_date" class="form-input-premium" value="{{ old('end_date', $batch->end_date) }}">
                        @error('end_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" value="1" name="is_current" id="is_current" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ old('is_current', $batch->is_current) ? 'checked' : '' }}>
                    <label for="is_current" class="ml-3 text-sm font-bold text-slate-700">Set as Current Active Batch</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('batches.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel Operation
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Batch
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
