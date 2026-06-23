@extends('layouts.admin')

@section('header', 'Furniture Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-2xl font-bold text-gray-800">Furniture Inventory</h3>
    <a href="{{ route('furniture.create') }}" class="btn-premium">
        <i class="fas fa-plus mr-2"></i> Add Item
    </a>
</div>

<div class="glass-card overflow-hidden">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Room / Building</th>
                <th>Condition</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($furniture as $item)
            <tr>
                <td class="font-mono text-xs font-bold">{{ $item->code }}</td>
                <td class="font-semibold text-indigo-600">{{ $item->name }}</td>
                <td>{{ $item->type }}</td>
                <td>
                    @if($item->room)
                        {{ $item->room->room_number }} ({{ $item->room->building->name }})
                    @else
                        <span class="text-gray-400 italic text-sm">Not Assigned</span>
                    @endif
                </td>
                <td>
                    <span class="px-2 py-1 text-[10px] font-bold rounded uppercase
                        {{ $item->condition == 'new' ? 'bg-green-100 text-green-700' : 
                          ($item->condition == 'good' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                        {{ $item->condition }}
                    </span>
                </td>
                <td>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $item->status == 'available' ? 'bg-emerald-100 text-emerald-700' : 
                          ($item->status == 'assigned' ? 'bg-indigo-100 text-indigo-700' : 'bg-orange-100 text-orange-700') }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td class="text-right space-x-2">
                    <a href="{{ route('furniture.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('furniture.destroy', $item) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8 text-gray-500">No furniture items found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="p-4 border-t border-gray-100">
        {{ $furniture->links() }}
    </div>
</div>
@endsection
