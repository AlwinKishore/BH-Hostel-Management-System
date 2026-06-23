@extends('layouts.admin')

@section('header', 'Student Management')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Student Hub</h3>
        <p class="text-sm text-slate-600 font-medium">Register and manage tenants across buildings</p>
    </div>
    <a href="{{ route('students.create') }}" class="btn-premium">
        <i class="fas fa-user-plus mr-2 opacity-70"></i> Register Student
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Identity</th>
                    <th>Correspondence</th>
                    <th>Allocation</th>
                    <th>Boarded On</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="group">
                    <td>
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-indigo-200 mr-4 transform hover:rotate-6 transition-transform">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 leading-tight">{{ $student->name }}</div>
                                <div class="text-[10px] text-slate-600 font-black uppercase tracking-widest mt-0.5">Ref: #{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm font-semibold text-slate-700">{{ $student->email }}</div>
                        <div class="text-xs text-slate-600 font-medium">{{ $student->phone }}</div>
                    </td>
                    <td>
                        @if($student->room)
                            <div class="inline-flex items-center px-3 py-1 bg-indigo-50 rounded-xl">
                                <i class="fas fa-door-open text-indigo-400 mr-2 text-[10px]"></i>
                                <span class="text-xs font-black text-indigo-700">Room {{ $student->room->room_number }}</span>
                            </div>
                            <div class="text-[9px] text-slate-600 font-bold uppercase mt-1 pl-1">{{ $student->room->building->name }}</div>
                        @else
                            <span class="text-slate-500 italic text-xs font-medium">Unallocated</span>
                        @endif
                    </td>
                    <td>
                        <div class="text-sm font-bold text-slate-700">
                            {{ $student->joining_date ? \Carbon\Carbon::parse($student->joining_date)->format('d M, Y') : '--' }}
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2">
                            <span class="block px-3 py-1 text-[9px] text-center font-black uppercase tracking-widest rounded-full 
                                {{ $student->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 
                                   ($student->status == 'inactive' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                                {{ $student->status }}
                            </span>
                            <span class="block px-3 py-1 text-[9px] text-center font-black uppercase tracking-widest rounded-full 
                                {{ $student->payment_status == 'paid' ? 'bg-indigo-600 text-white' : 
                                   ($student->payment_status == 'partially_paid' ? 'bg-amber-400 text-white' : 'bg-rose-500 text-white') }}">
                                {{ str_replace('_', ' ', $student->payment_status) }}
                            </span>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('students.edit', $student) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-fingerprint"></i>
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
                    <td colspan="6" class="text-center py-20">
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
