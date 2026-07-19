@extends('layouts.admin')

@section('header', 'Create Batch')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('batches.index') }}" class="hover:text-indigo-600 transition-colors">Batchs</a>
        <span>/</span>
        <span class="text-slate-800">New Registration</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Create New Batch</h3>
            <p class="text-sm text-slate-600 font-medium">Add a new batch designation</p>
        </div>

        <form action="{{ route('batches.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="batch_name" class="form-label-premium">Batch Designation <span class="text-red-500">*</span></label>
                    <input type="text" name="batch_name" id="batch_name" class="form-input-premium" placeholder="e.g. 1st Batch, 2nd Batch, Senior" value="{{ old('batch_name') }}" required>
                    @error('batch_name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="academic_year_id" class="form-label-premium">Related Academic Year <span class="text-red-500">*</span></label>
                    <select name="academic_year_id" id="academic_year_id" class="form-input-premium" required>
                        <option value="">-- Select Academic Year --</option>
                        @foreach($academic_years as $academic_year)
                            <option value="{{ $academic_year->id }}" {{ old('academic_year_id') == $academic_year->id ? 'selected' : '' }}>
                                {{ $academic_year->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" value="1" name="is_active" id="is_active" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-3 text-sm font-bold text-slate-700">Batch is Active</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('batches.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Save Batch
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
