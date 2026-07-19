@extends('layouts.admin')

@section('header', 'Daily Attendance')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Attendance</h3>
        <p class="text-sm text-slate-600 font-medium">Daily roll call and presence verification</p>
    </div>
</div>

<div class="glass-card p-8 mb-8 border-none shadow-xl shadow-slate-200/50">
    <form action="{{ route('attendance.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
        <div class="flex-1 min-w-[200px]">
            <label for="date" class="form-label-premium">Operational Date</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-500 transition-colors">
                    <i class="fas fa-calendar-day text-sm"></i>
                </div>
                <input type="date" name="date" id="date" value="{{ $date }}" class="form-input-premium !text-slate-800 !bg-slate-50 !border-slate-200 pl-11">
            </div>
        </div>

        <button type="submit" class="btn-premium px-8 py-3.5">
            <i class="fas fa-bolt mr-2 opacity-70"></i> Load Roster
        </button>
    </form>
</div>

<div class="glass-card overflow-hidden border-none shadow-2xl shadow-slate-300/30">
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        
        <div class="flex flex-col md:flex-row justify-between items-center p-8 border-b border-slate-100 bg-white/50 backdrop-blur-sm gap-4">
            <div>
                <h4 class="text-lg font-black text-slate-800">Roll Call Roster</h4>
                <p class="text-xs text-slate-600 font-bold uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider border border-emerald-100">
                    <i class="fas fa-check-double mr-2"></i> Present
                </div>
                <div class="flex items-center px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 text-[10px] font-black uppercase tracking-wider border border-rose-100">
                    <i class="fas fa-user-xmark mr-2"></i> Absent
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Hosteller</th>
                        <th>Room / Hostel</th>
                        <th class="text-center">Status Assignment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupedStudents as $groupName => $studentsGroup)
                        <tr class="bg-indigo-50/50 border-y border-indigo-100/50">
                            <td colspan="3" class="py-3 px-6 text-[10px] font-black text-indigo-700 uppercase tracking-[0.2em] shadow-inner">
                                <i class="fas fa-layer-group mr-2 opacity-70"></i> {{ $groupName }}
                                <span class="float-right bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">{{ $studentsGroup->count() }} Students</span>
                            </td>
                        </tr>
                        @foreach($studentsGroup as $student)
                        @php
                            $attendanceRecord = $student->attendances->first();
                            $attendanceStatus = $attendanceRecord ? ($attendanceRecord->is_present ? 'present' : 'absent') : 'present';
                        @endphp
                        <tr class="group">
                            <td>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black border border-slate-200 mr-4 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-500 transition-all duration-300">
                                        {{ substr($student->student_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $student->student_name }}</div>
                                        <div class="text-[9px] text-slate-600 uppercase">D.No: {{ $student->dno ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($student->room)
                                    <div class="text-sm font-bold text-slate-700">Room {{ $student->room->room_no }}</div>
                                    <div class="text-[9px] text-slate-600 font-black uppercase tracking-widest">Hostel {{ $student->hostel_no }}</div>
                                @else
                                    <span class="text-slate-500 italic text-xs">Unassigned</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="flex justify-center space-x-4">
                                    <label class="cursor-pointer group/opt">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="present" class="hidden peer" {{ $attendanceStatus == 'present' ? 'checked' : '' }}>
                                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl border-2 border-slate-100 text-slate-200 peer-checked:bg-emerald-500 peer-checked:border-emerald-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-emerald-500/30 transition-all duration-200 hover:border-emerald-200 active:scale-90">
                                            <i class="fas fa-check text-lg"></i>
                                        </div>
                                    </label>
                                    
                                    <label class="cursor-pointer group/opt">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="hidden peer" {{ $attendanceStatus == 'absent' ? 'checked' : '' }}>
                                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl border-2 border-slate-100 text-slate-200 peer-checked:bg-rose-500 peer-checked:border-rose-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-rose-500/30 transition-all duration-200 hover:border-rose-200 active:scale-90">
                                            <i class="fas fa-times text-lg"></i>
                                        </div>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-20">
                            <i class="fas fa-inbox text-4xl text-slate-200 mb-4 block"></i>
                            <span class="font-bold text-slate-500">No active students on roster.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($groupedStudents->isNotEmpty())
        <div class="p-10 bg-slate-50/50 border-t border-slate-100 flex justify-center md:justify-end">
            <button type="submit" class="btn-primary bg-indigo-600 text-white hover:bg-indigo-700 px-16 py-4 rounded-xl shadow-xl shadow-indigo-600/30 transition-all font-bold font-sm">
                <i class="fas fa-cloud-arrow-up mr-3 opacity-70"></i> Commit Roster to Database
            </button>
        </div>
        @endif
    </form>
</div>
@endsection
