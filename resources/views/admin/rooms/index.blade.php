@extends('layouts.admin')

@section('header', 'Rooms Management')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Rooms</h3>
        <p class="text-sm text-slate-600 font-medium">Manage individual units and occupancy status</p>
    </div>
    <a href="{{ route('rooms.create') }}" class="btn-premium">
        <i class="fas fa-plus-circle mr-2 opacity-70"></i> Add New Room
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Room #</th>
                    <th>Building & Floor</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr class="group">
                    <td>
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-700 font-black rounded-xl border border-indigo-100 mb-1">
                            {{ $room->room_number }}
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-slate-800">{{ $room->building->name }}</div>
                        <div class="text-[10px] text-slate-600 font-black uppercase tracking-wider">Floor {{ $room->floor }}</div>
                    </td>
                    <td>
                        <span class="text-xs font-bold text-slate-700 px-3 py-1 bg-slate-100 rounded-lg italic">
                            {{ ucfirst($room->type) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center text-slate-700 font-bold text-xs">
                            <i class="fas fa-users mr-2 opacity-50"></i>
                            {{ $room->capacity }} Persons
                        </div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                            {{ $room->status == 'vacant' ? 'bg-emerald-100 text-emerald-700' : 
                               ($room->status == 'occupied' ? 'bg-sky-100 text-sky-700' : 'bg-rose-100 text-rose-700') }}">
                            {{ $room->status }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('rooms.edit', $room) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-pen-nib"></i>
                            </a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition-colors" onclick="return confirm('Remove this room permanently?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-20">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-door-closed text-2xl text-slate-400"></i>
                            </div>
                            <span class="font-bold text-slate-500">No rooms configured yet.</span>
                        </div>
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
