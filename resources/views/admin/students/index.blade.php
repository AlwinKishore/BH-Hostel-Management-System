@extends('layouts.admin')

@section('header', 'Student Management')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Hosteller Hub</h3>
        <p class="text-sm text-slate-600 font-medium">Register and manage tenants across buildings</p>
    </div>
    <a href="{{ route('students.create') }}" class="btn-premium">
        <i class="fas fa-user-plus mr-2 opacity-70"></i> Register Hosteller
    </a>
</div>

<div class="glass-card p-6 mb-8 border-none shadow-xl shadow-slate-200/50">
    <form action="{{ route('students.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="form-label-premium">Search Students</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-500 transition-colors">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-input-premium !pl-11" placeholder="Name, Hostel No, or D.No">
            </div>
        </div>
        
        <div class="w-full md:w-64">
            <label for="academic_year_id" class="form-label-premium">Academic Year</label>
            <select name="academic_year_id" id="academic_year_id" class="form-input-premium">
                <option value="">All Academic Years</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-premium px-8 py-3.5">
            <i class="fas fa-filter mr-2 opacity-70"></i> Filter
        </button>
        
        @if(request()->hasAny(['search', 'academic_year_id']))
        <a href="{{ route('students.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-rose-500 transition-colors px-2">
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
                    <th>Identity</th>
                    <th>Academic Year / Batch</th>
                    <th>Hostel / D.No</th>
                    <th>Allocation</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="group">
                    <td>
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-indigo-200 mr-4 transform hover:rotate-6 transition-transform">
                                {{ substr($student->student_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 leading-tight">{{ $student->student_name }}</div>
                                <div class="text-[10px] text-slate-600 font-black uppercase tracking-widest mt-0.5">Ref: #{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm font-semibold text-slate-700">{{ $student->academicYear ? $student->academicYear->name : 'No Academic Year' }}</div>
                        <div class="text-xs text-slate-600 font-medium">{{ $student->batch ? $student->batch->batch_name : 'No Batch' }}</div>
                    </td>
                    <td>
                        <div class="text-sm font-semibold text-slate-700">Hostel: {{ $student->hostel_no }}</div>
                        <div class="text-xs text-slate-600 font-medium">D.No: {{ $student->dno ?? 'N/A' }}</div>
                    </td>
                    <td>
                        @if($student->room)
                            <div class="inline-flex items-center px-3 py-1 bg-indigo-50 rounded-xl">
                                <i class="fas fa-door-open text-indigo-400 mr-2 text-[10px]"></i>
                                <span class="text-xs font-black text-indigo-700">Room {{ $student->room->room_no }}</span>
                            </div>
                        @else
                            <span class="text-slate-500 italic text-xs font-medium">Unallocated</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 transition-opacity">
                            <a href="{{ route('students.edit', $student) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition-colors" onclick="return confirm('Deregister this student?')">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-user-slash text-2xl text-slate-400"></i>
                            </div>
                            <span class="font-bold text-slate-500">No student records found.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($students->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $students->links() }}
    </div>
    @endif
</div>
@endsection
