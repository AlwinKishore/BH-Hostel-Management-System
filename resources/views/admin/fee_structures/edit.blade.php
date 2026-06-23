@extends('layouts.admin')

@section('header', 'Update Pricing Structure')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('fee-structures.index') }}" class="hover:text-indigo-600 transition-colors">Prices Palette</a>
        <span>/</span>
        <span class="text-slate-800">Operational Update</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Pricing Logic</h3>
            <p class="text-sm text-slate-600 font-medium">Update recurring charges, billing cycles, or building associations</p>
        </div>

        <form action="{{ route('fee-structures.update', $feeStructure) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label for="name" class="form-label-premium">Fee Nomenclature (Name)</label>
                    <input type="text" name="name" id="name" class="form-input-premium" value="{{ old('name', $feeStructure->name) }}" required>
                </div>

                <div class="md:col-span-2 text-indigo-500">
                    <label class="form-label-premium">Billing Cycle Frequency</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach(['monthly' => 'Every Month', 'quarterly' => 'Every Quarter', 'yearly' => 'Annual / Year'] as $freq => $label)
                        <label class="cursor-pointer group">
                            <input type="radio" name="frequency" value="{{ $freq }}" class="hidden peer" {{ old('frequency', $feeStructure->frequency) == $freq ? 'checked' : '' }}>
                            <div class="p-6 rounded-2xl border-2 border-transparent bg-slate-50 flex flex-col items-center justify-center transition-all peer-checked:border-indigo-600 peer-checked:bg-white peer-checked:shadow-xl group-hover:bg-slate-100">
                                <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-indigo-600">
                                    <i class="fas {{ $freq == 'monthly' ? 'fa-calendar-day' : ($freq == 'quarterly' ? 'fa-calendar-week' : 'fa-calendar-check') }} text-xl"></i>
                                </div>
                                <span class="text-sm font-black text-slate-800">{{ ucfirst($freq) }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-widest">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="amount" class="form-label-premium font-black">Monetary Value (Amount)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-input-premium pl-12 border-emerald-100 focus:border-emerald-500" value="{{ old('amount', $feeStructure->amount) }}" required>
                    </div>
                </div>

                <div>
                    <label for="room_type" class="form-label-premium">Applicable Room Type (Optional)</label>
                    <input type="text" name="room_type" id="room_type" class="form-input-premium" value="{{ old('room_type', $feeStructure->room_type) }}">
                </div>

                <div class="md:col-span-2">
                    <label class="form-label-premium">Building Association</label>
                    <div class="flex flex-wrap gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="building_id" value="" class="hidden peer" {{ !old('building_id', $feeStructure->building_id) ? 'checked' : '' }}>
                            <div class="px-6 py-3 rounded-xl border-2 border-transparent bg-slate-50 text-xs font-black uppercase tracking-widest text-slate-500 transition-all peer-checked:border-slate-800 peer-checked:bg-slate-800 peer-checked:text-white">
                                Global (All)
                            </div>
                        </label>
                        @foreach($buildings as $building)
                        <label class="cursor-pointer">
                            <input type="radio" name="building_id" value="{{ $building->id }}" class="hidden peer" {{ old('building_id', $feeStructure->building_id) == $building->id ? 'checked' : '' }}>
                            <div class="px-6 py-3 rounded-xl border-2 border-transparent bg-slate-50 text-xs font-black uppercase tracking-widest text-slate-500 transition-all peer-checked:border-indigo-600 peer-checked:bg-white peer-checked:text-indigo-600">
                                {{ $building->name }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="form-label-premium">Detailed Clarification</label>
                    <textarea name="description" id="description" rows="3" class="form-input-premium py-4">{{ old('description', $feeStructure->description) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('fee-structures.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard Changes
                </a>
                <button type="submit" class="btn-premium px-12 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Structure
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
