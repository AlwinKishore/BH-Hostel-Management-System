@extends('layouts.admin')

@section('header', 'Leave Requests')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Leave Requests</h3>
        <p class="text-sm text-slate-600 font-medium">Manage and review student leaves</p>
    </div>
    <a href="{{ route('leaves.create') }}" class="btn-premium">
        <i class="fas fa-plus mr-2 opacity-70"></i> Create Leave Request
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Hosteller</th>
                    <th>Dates</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr class="group">
                    <td>
                        <div class="font-bold text-slate-800 tracking-tight">
                            {{ $leave->hosteller ? $leave->hosteller->student_name . ' (H.No. ' . $leave->hosteller->hostel_no . ')' : 'Unknown Hosteller' }}
                        </div>
                    </td>
                    <td>
                        <div class="text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d M, Y') }} - 
                            {{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="text-sm text-slate-600 truncate max-w-xs">{{ $leave->reason }}</div>
                    </td>
                    <td>
                        @if($leave->is_approved === 1)
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700">Approved</span>
                        @elseif($leave->is_approved === 0)
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-100 text-rose-700">Rejected</span>
                        @else
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-amber-100 text-amber-700">Pending</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 transition-opacity">
                            <a href="{{ route('leaves.edit', $leave) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" onclick="return confirm('Are you sure you want to delete this leave?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20 italic font-bold text-slate-400">
                        No leave requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($leaves->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $leaves->links() }}
    </div>
    @endif
</div>
@endsection
