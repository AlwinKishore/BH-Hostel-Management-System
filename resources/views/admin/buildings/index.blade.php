@extends('layouts.admin')

@section('header', 'Buildings Management')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Buildings</h3>
        <p class="text-sm text-slate-600 font-medium">Manage your hostel infrastructure and assets</p>
    </div>
    <a href="{{ route('buildings.create') }}" class="btn-premium">
        <i class="fas fa-plus-circle mr-2 opacity-70"></i> Add New Building
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Building Name</th>
                    <th>Address</th>
                    <th>Floors</th>
                    <th>Rooms</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buildings as $building)
                <tr class="group">
                    <td class="text-xs font-black text-slate-500">#{{ str_pad($building->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="font-bold text-slate-800">{{ $building->name }}</div>
                        <div class="text-[10px] text-slate-600 font-bold uppercase tracking-wider">Capacity: {{ $building->capacity }}</div>
                    </td>
                    <td class="text-sm text-slate-700 max-w-xs truncate">{{ $building->address }}</td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-black bg-slate-100 text-slate-700">
                            {{ $building->total_floors }} Floors
                        </span>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-black bg-indigo-50 text-indigo-600">
                            {{ $building->total_rooms }} Rooms
                        </span>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                            {{ $building->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $building->status }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('buildings.edit', $building) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-pen-nib"></i>
                            </a>
                            <form action="{{ route('buildings.destroy', $building) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition-colors" onclick="return confirm('Archive this building?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-20">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-building text-2xl text-slate-400"></i>
                            </div>
                            <span class="font-bold text-slate-500">No buildings registered yet.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($buildings->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $buildings->links() }}
    </div>
    @endif
</div>
@endsection
