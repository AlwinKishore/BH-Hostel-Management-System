@extends('layouts.admin')

@section('header', 'Global Search Results')

@section('content')
<div class="mb-10">
    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Search Results</h3>
    <p class="text-sm text-slate-600 font-medium">
        @if($query)
            Showing results for "<span class="font-bold text-indigo-600">{{ $query }}</span>"
        @else
            Please enter a search query
        @endif
    </p>
</div>

@if($query)
<div class="space-y-10">
    <!-- Students Results -->
    <div>
        <h4 class="text-xl font-black text-slate-800 mb-4 border-b border-slate-200 pb-2">
            Hostellers <span class="text-sm bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full ml-2">{{ $students->count() }}</span>
        </h4>
        @if($students->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($students as $student)
            <a href="{{ route('students.edit', $student) }}" class="glass-card p-6 block hover:bg-slate-900 group transition-all duration-300">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-800 group-hover:text-white transition-colors">{{ $student->student_name }}</h5>
                        <div class="text-xs text-slate-500 group-hover:text-slate-400 font-medium">D.No: {{ $student->dno }} | Hostel: {{ $student->hostel_no }}</div>
                        <div class="text-[10px] uppercase font-black tracking-widest text-indigo-600 group-hover:text-indigo-400 mt-2">View details &rarr;</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="p-8 bg-slate-50 border border-slate-100 rounded-3xl text-center italic text-sm font-medium text-slate-500">
            No hostellers found matching your query.
        </div>
        @endif
    </div>

    <!-- Rooms Results -->
    <div>
        <h4 class="text-xl font-black text-slate-800 mb-4 border-b border-slate-200 pb-2">
            Rooms <span class="text-sm bg-sky-100 text-sky-600 px-2 py-0.5 rounded-full ml-2">{{ $rooms->count() }}</span>
        </h4>
        @if($rooms->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rooms as $room)
            <a href="{{ route('rooms.edit', $room) }}" class="glass-card p-6 block hover:bg-slate-900 group transition-all duration-300">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                        <i class="fas fa-door-open text-xl"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-800 group-hover:text-white transition-colors">Room {{ $room->room_no }}</h5>
                        <div class="text-xs text-slate-500 group-hover:text-slate-400 font-medium">Category: {{ $room->category ? $room->category->name : 'N/A' }}</div>
                        <div class="text-[10px] uppercase font-black tracking-widest text-sky-600 group-hover:text-sky-400 mt-2">Manage Room &rarr;</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="p-8 bg-slate-50 border border-slate-100 rounded-3xl text-center italic text-sm font-medium text-slate-500">
            No rooms found matching your query.
        </div>
        @endif
    </div>
</div>
@endif

@endsection
