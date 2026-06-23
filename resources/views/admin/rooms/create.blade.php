@extends('layouts.admin')

@section('header', 'Add New Room')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('rooms.index') }}" class="hover:text-indigo-600 transition-colors">Rooms</a>
        <span>/</span>
        <span class="text-slate-800">Add New</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Register Room</h3>
            <p class="text-sm text-slate-600 font-medium">Configure a new residential unit with specific occupancy metrics</p>
        </div>

        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="building_id" class="form-label-premium">Target Building</label>
                    <div class="relative group">
                        <select name="building_id" id="building_id" class="form-input-premium appearance-none" required>
                            <option value="">Select Infrastructure Asset</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" data-floors="{{ $building->total_floors }}" data-capacity="{{ $building->capacity }}">
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    @error('building_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="room_number" class="form-label-premium">Room Identifier / Number</label>
                    <input type="text" name="room_number" id="room_number" class="form-input-premium" placeholder="e.g. 101, B-202" value="{{ old('room_number') }}" required>
                    @error('room_number') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="floor" class="form-label-premium">Floor Level <span id="floor-hint" class="text-[9px] lowercase font-normal italic opacity-60 ml-2"></span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <input type="number" name="floor" id="floor" min="0" class="form-input-premium pl-12" value="{{ old('floor', 0) }}" required>
                    </div>
                    @error('floor') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="capacity" class="form-label-premium">Beds <span id="capacity-hint" class="text-[9px] lowercase font-normal italic opacity-60 ml-1"></span></label>
                        <input type="number" name="capacity" id="capacity" min="1" class="form-input-premium" value="{{ old('capacity', 2) }}" required>
                        @error('capacity') <p class="mt-1 text-[9px] font-black uppercase text-rose-500 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="type" class="form-label-premium">Room Type</label>
                        <select name="type" id="type" class="form-input-premium appearance-none">
                            <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="double" {{ old('type') == 'double' || !old('type') ? 'selected' : '' }}>Double</option>
                            <option value="triple" {{ old('type') == 'triple' ? 'selected' : '' }}>Triple</option>
                            <option value="dormitory" {{ old('type') == 'dormitory' ? 'selected' : '' }}>Dormitory</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="price" class="form-label-premium">Monthly Rent / Price</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <input type="number" step="0.01" name="price" id="price" class="form-input-premium pl-12" placeholder="0.00" value="{{ old('price', 0) }}" required>
                    </div>
                </div>

                <div>
                    <label for="status" class="form-label-premium">Initial Operational Status</label>
                    <select name="status" id="status" class="form-input-premium appearance-none">
                        <option value="vacant" {{ old('status') == 'vacant' || !old('status') ? 'selected' : '' }}>Vacant & Available</option>
                        <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('rooms.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-check-circle mr-2 opacity-70"></i> Save Room
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buildingSelect = document.getElementById('building_id');
        const floorInput = document.getElementById('floor');
        const capacityInput = document.getElementById('capacity');
        const floorHint = document.getElementById('floor-hint');
        const capacityHint = document.getElementById('capacity-hint');

        function updateLimits() {
            const selectedOption = buildingSelect.options[buildingSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const maxFloors = selectedOption.getAttribute('data-floors');
                const maxCapacity = selectedOption.getAttribute('data-capacity');

                floorInput.max = maxFloors;
                capacityInput.max = maxCapacity;

                floorHint.textContent = `(Max: ${maxFloors})`;
                capacityHint.textContent = `(Max: ${maxCapacity})`;
            } else {
                floorInput.removeAttribute('max');
                capacityInput.removeAttribute('max');
                floorHint.textContent = '';
                capacityHint.textContent = '';
            }
        }

        buildingSelect.addEventListener('change', updateLimits);
        updateLimits(); // Initial run
    });
</script>
@endsection
