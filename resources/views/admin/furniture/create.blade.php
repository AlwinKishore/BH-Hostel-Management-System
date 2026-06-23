@extends('layouts.admin')

@section('header', 'Add Furniture Item')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('furniture.index') }}" class="hover:text-indigo-600 transition-colors">Furniture</a>
        <span>/</span>
        <span class="text-slate-800">New Asset</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Register Furniture</h3>
            <p class="text-sm text-slate-600 font-medium">Add a new asset to the hostel inventory or assign it to a room</p>
        </div>

        <form action="{{ route('furniture.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="name" class="form-label-premium">Item Name</label>
                    <input type="text" name="name" id="name" class="form-input-premium" placeholder="e.g. Wooden Bed Frame" value="{{ old('name') }}" required>
                    @error('name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="code" class="form-label-premium">Asset Code / Serial</label>
                    <input type="text" name="code" id="code" class="form-input-premium" placeholder="e.g. FUR-001" value="{{ old('code') }}" required>
                    @error('code') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="type" class="form-label-premium">Furniture Category</label>
                            <div class="relative group">
                                <select name="type" id="type" class="form-input-premium appearance-none" required>
                                    <option value="Bed">Bed</option>
                                    <option value="Table">Table</option>
                                    <option value="Chair">Chair</option>
                                    <option value="Cupboard">Cupboard</option>
                                    <option value="Fan">Fan</option>
                                    <option value="Air Conditioner">Air Conditioner</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="room_id" class="form-label-premium">Assign to Room <span class="text-[9px] lowercase font-normal italic opacity-60 ml-1">(Optional)</span></label>
                            <div class="relative group">
                                <select name="room_id" id="room_id" class="form-input-premium appearance-none">
                                    <option value="">Stay in Inventory</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_number }} - {{ $room->building->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-search-location text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="condition" class="form-label-premium">Physical Condition</label>
                    <select name="condition" id="condition" class="form-input-premium appearance-none">
                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Brand New</option>
                        <option value="good" {{ old('condition') == 'good' || !old('condition') ? 'selected' : '' }}>Good / Serviceable</option>
                        <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                        <option value="repairable" {{ old('condition') == 'repairable' ? 'selected' : '' }}>Under Repair</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="form-label-premium">Operational Status</label>
                    <select name="status" id="status" class="form-input-premium appearance-none">
                        <option value="available" {{ old('status') == 'available' || !old('status') ? 'selected' : '' }}>Available for Assignment</option>
                        <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>Already Assigned</option>
                        <option value="broken" {{ old('status') == 'broken' ? 'selected' : '' }}>Broken / Out of Service</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Scheduled Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('furniture.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-check-circle mr-2 opacity-70"></i> Register Item
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
