@extends('layouts.admin')

@section('header', 'Occupancy Analytics')

@section('content')
<div class="mb-6 flex items-center space-x-2 text-gray-400 font-medium text-sm">
    <a href="{{ route('reports.index') }}" class="hover:text-indigo-600 transition-colors">Reports</a>
    <span>/</span>
    <span class="text-gray-800">Occupancy Breakdown</span>
</div>

<div class="glass-card">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Building Name</th>
                <th>Total Rooms</th>
                <th>Occupied</th>
                <th>Vacant</th>
                <th>Occupancy %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buildings as $building)
            @php
                $occupied = $building->rooms_count - $building->vacant_rooms_count;
                $percentage = $building->rooms_count > 0 ? ($occupied / $building->rooms_count) * 100 : 0;
            @endphp
            <tr>
                <td class="font-bold text-gray-800">{{ $building->name }}</td>
                <td>{{ $building->rooms_count }}</td>
                <td class="text-indigo-600 font-semibold">{{ $occupied }}</td>
                <td class="text-green-600 font-semibold">{{ $building->vacant_rooms_count }}</td>
                <td>
                    <div class="flex items-center">
                        <div class="flex-1 bg-gray-200 rounded-full h-2 mr-3 min-w-[100px]">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-gray-600">{{ round($percentage) }}%</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
