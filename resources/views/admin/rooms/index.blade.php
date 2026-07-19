@extends('layouts.admin')

@section('header', 'Rooms')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Hostel Rooms</h3>
        <p class="text-sm text-slate-600 font-medium">Manage accommodation capacity and room assignments</p>
    </div>
    <a href="{{ route('rooms.create') }}" class="btn-premium">
        <i class="fas fa-bed mr-2 opacity-70"></i> Add New Room
    </a>
</div>

<div class="glass-card p-6 mb-8 border-none shadow-xl shadow-slate-200/50">
    <form action="{{ route('rooms.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="form-label-premium">Search Rooms</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-500 transition-colors">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-input-premium !pl-11" placeholder="Room No">
            </div>
        </div>
        
        <div class="w-full md:w-48">
            <label for="category_id" class="form-label-premium">Category</label>
            <select name="category_id" id="category_id" class="form-input-premium">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-48">
            <label for="availability" class="form-label-premium">Status</label>
            <select name="availability" id="availability" class="form-input-premium">
                <option value="">All Statuses</option>
                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="full" {{ request('availability') == 'full' ? 'selected' : '' }}>Full</option>
            </select>
        </div>

        <button type="submit" class="btn-premium px-8 py-3.5">
            <i class="fas fa-filter mr-2 opacity-70"></i> Filter
        </button>
        
        @if(request()->hasAny(['search', 'category_id', 'availability']))
        <a href="{{ route('rooms.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-rose-500 transition-colors px-2">
            Clear
        </a>
        @endif
    </form>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Room Details</th>
                    <th>Category</th>
                    <th>Capacity</th>
                    <th>Availability</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr class="group">
                    <td>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white font-black mr-4 shadow-lg shadow-orange-500/20">
                                {{ substr($room->room_no, 0, 2) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 tracking-tight">{{ $room->room_no }}</div>
                                <div class="text-[10px] uppercase font-black tracking-widest text-slate-400">Floor: {{ $room->floor ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm font-medium text-slate-600">{{ $room->category ? $room->category->category_name : 'Standard' }}</div>
                    </td>
                    <td>
                        <div class="text-sm font-black text-slate-700">{{ $room->hostellers_count }} / {{ $room->accommodation }} Person(s)</div>
                        <div class="w-full bg-slate-200 rounded-full h-1.5 mt-2">
                            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $room->accommodation > 0 ? min(100, ($room->hostellers_count / $room->accommodation) * 100) : 0 }}%"></div>
                        </div>
                    </td>
                    <td>
                        @if(!$room->is_available)
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                Unavailable
                            </span>
                        @elseif($room->hostellers_count >= $room->accommodation)
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                Filled
                            </span>
                        @else
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                Available
                            </span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 transition-opacity">
                            <a href="{{ route('rooms.edit', $room) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" onclick="return confirm('Deleting this room will update all associated hosteller records. Do you want to proceed?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20 italic font-bold text-slate-400">
                        No rooms found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($rooms->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $rooms->links() }}
    </div>
    @endif
</div>
@endsection
