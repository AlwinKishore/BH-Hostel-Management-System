@extends('layouts.admin')

@section('header', 'Add New Building')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('buildings.index') }}" class="hover:text-indigo-600 transition-colors">Infrastructure</a>
        <span>/</span>
        <span class="text-slate-800">New Asset</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Register Building</h3>
            <p class="text-sm text-slate-600 font-medium">Initialize a new residential block in the system</p>
        </div>

        <form action="{{ route('buildings.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label for="name" class="form-label-premium">Building Identifier / Name</label>
                    <input type="text" name="name" id="name" class="form-input-premium" placeholder="e.g. Platinum Block, North Wing" required>
                    @error('name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="form-label-premium">Geographic Location / Address</label>
                    <textarea name="address" id="address" rows="3" class="form-input-premium resize-none" placeholder="Physical address for logistics and emergencies"></textarea>
                    @error('address') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="total_floors" class="form-label-premium">Floors Levels</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <input type="number" name="total_floors" id="total_floors" min="1" class="form-input-premium pl-12" value="1" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="total_rooms" class="form-label-premium">Total Rooms</label>
                        <input type="number" name="total_rooms" id="total_rooms" min="0" class="form-input-premium" value="0" required>
                    </div>
                    <div>
                        <label for="capacity" class="form-label-premium">Max Capacity</label>
                        <input type="number" name="capacity" id="capacity" min="0" class="form-input-premium" value="0" required>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="status" class="form-label-premium">Operational Status</label>
                    <select name="status" id="status" class="form-input-premium appearance-none">
                        <option value="active">Active & Operational</option>
                        <option value="inactive">Inactive / Under Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('buildings.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-check-circle mr-2 opacity-70"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
