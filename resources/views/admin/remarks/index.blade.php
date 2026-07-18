@extends('layouts.admin')

@section('header', 'Student Remarks')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Disciplinary & General Remarks</h3>
        <p class="text-sm text-slate-600 font-medium">Log and manage notes regarding student conduct</p>
    </div>
    <a href="{{ route('remarks.create') }}" class="btn-premium">
        <i class="fas fa-plus mr-2 opacity-70"></i> Add New Remark
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Hosteller</th>
                    <th>Date Logged</th>
                    <th>Remark / Note</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($remarks as $remark)
                <tr class="group">
                    <td>
                        <div class="font-bold text-slate-800 tracking-tight">
                            {{ $remark->hosteller ? $remark->hosteller->student_name . ' (H.No. ' . $remark->hosteller->hostel_no . ')' : 'Unknown Hosteller' }}
                        </div>
                    </td>
                    <td>
                        <div class="text-sm text-slate-600">
                            {{ $remark->created_at->format('d M, Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="text-sm text-slate-600 truncate max-w-sm">{{ $remark->remarks }}</div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 transition-opacity">
                            <a href="{{ route('remarks.edit', $remark) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('remarks.destroy', $remark) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" onclick="return confirm('Are you sure you want to delete this remark?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-20 italic font-bold text-slate-400">
                        No remarks logged yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($remarks->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $remarks->links() }}
    </div>
    @endif
</div>
@endsection
