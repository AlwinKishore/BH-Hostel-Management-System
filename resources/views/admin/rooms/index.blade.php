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
                        <div class="text-sm font-black text-slate-700">{{ $room->accommodation }} Person(s)</div>
                    </td>
                    <td>
                        @if(!$room->is_available)
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                Unavailable
                            </span>
                        @elseif($room->is_full)
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
