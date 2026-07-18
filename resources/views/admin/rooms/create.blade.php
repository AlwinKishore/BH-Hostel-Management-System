@extends('layouts.admin')

@section('header', 'Add Room')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('rooms.index') }}" class="hover:text-indigo-600 transition-colors">Rooms</a>
        <span>/</span>
        <span class="text-slate-800">Add Registration</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Add New Room</h3>
            <p class="text-sm text-slate-600 font-medium">Register a new room to the hostel inventory</p>
        </div>

        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="room_no" class="form-label-premium">Room Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="room_no" id="room_no" class="form-input-premium" value="{{ old('room_no') }}" required>
                    <!-- placeholder="e.g. A-101" -->
                    @error('room_no') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="room_category" class="form-label-premium">Room Category <span class="text-rose-500">*</span></label>
                    <select name="room_category" id="room_category" class="form-input-premium" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('room_category') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_category') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="floor" class="form-label-premium">Floor Level <span class="text-rose-500">*</span></label>
                    <input type="text" name="floor" id="floor" class="form-input-premium" value="{{ old('floor') }}" required>
                    <!-- placeholder="e.g. Ground Floor, 1st Floor" -->
                    @error('floor') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="accommodation" class="form-label-premium">Accommodation Capacity (Beds) <span class="text-rose-500">*</span></label>
                    <input type="number" name="accommodation" id="accommodation" class="form-input-premium" min="1" max="20" value="{{ old('accommodation', 1) }}" required>
                    <!-- placeholder="e.g. 2"  -->
                    @error('accommodation') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-col space-y-4 mt-6 p-6 bg-slate-50/50 rounded-2xl border border-slate-100">
                <div class="flex items-center">
                    <input type="checkbox" value="1" name="is_available" id="is_available" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ old('is_available', true) ? 'checked' : '' }}>
                    <label for="is_available" class="ml-3 text-sm font-bold text-slate-700">Room is Available for Assignment</label>
                </div>
                
                <!-- <div class="flex items-center">
                    <input type="checkbox" value="1" name="is_full" id="is_full" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ old('is_full') ? 'checked' : '' }}>
                    <label for="is_full" class="ml-3 text-sm font-bold text-slate-700">Room is Currently at Full Capacity</label>
                </div> -->
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('rooms.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-save mr-2 opacity-70"></i> Save Room
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
