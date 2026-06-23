@extends('layouts.admin')

@section('header', 'Student Complaints')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Grievance Portal</h3>
        <p class="text-sm text-slate-600 font-medium">Analyze and resolve student feedback and operational issues</p>
    </div>
    <a href="{{ route('complaints.create') }}" class="btn-premium">
        <i class="fas fa-bullhorn mr-2 opacity-70"></i> Log New Complaint
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Classification</th>
                    <th>Subject & Brief</th>
                    <th>Complainant</th>
                    <th>Case Status</th>
                    <th>Log Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $comp)
                <tr class="group">
                    <td>
                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-500 bg-indigo-50 px-2 py-1 rounded-lg border border-indigo-100 italic">
                            {{ $comp->category }}
                        </span>
                    </td>
                    <td>
                        <div class="font-bold text-slate-800 leading-tight">{{ $comp->title }}</div>
                        <div class="text-[10px] text-slate-600 font-bold tracking-tight mt-1 max-w-[200px] truncate">{{ $comp->description }}</div>
                    </td>
                    <td>
                        <div class="text-sm font-bold text-slate-700">{{ $comp->student->name }}</div>
                        <div class="text-[9px] text-slate-600 font-black uppercase mt-0.5 tracking-widest">ID: #{{ str_pad($comp->student_id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                            {{ $comp->status == 'resolved' ? 'bg-emerald-100 text-emerald-700' : 
                               ($comp->status == 'pending' ? 'bg-amber-100 text-amber-700' : 
                               ($comp->status == 'closed' ? 'bg-slate-100 text-slate-500' : 'bg-rose-100 text-rose-700')) }}">
                            {{ $comp->status }}
                        </span>
                    </td>
                    <td>
                        <div class="text-sm font-bold text-slate-700">
                            {{ $comp->created_at->format('d M, Y') }}
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('complaints.edit', $comp) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-comment-dots"></i>
                            </a>
                            <form action="{{ route('complaints.destroy', $comp) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition-colors" onclick="return confirm('Archive this grievance?')">
                                    <i class="fas fa-trash-can"></i>
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
                                <i class="fas fa-face-smile text-2xl text-slate-400"></i>
                            </div>
                            <span class="font-bold text-slate-500">System is grievance-free.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($complaints->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $complaints->links() }}
    </div>
    @endif
</div>
@endsection
