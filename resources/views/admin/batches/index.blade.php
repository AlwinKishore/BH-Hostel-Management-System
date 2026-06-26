@extends('layouts.admin')

@section('header', 'Batches')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Academic Batches</h3>
        <p class="text-sm text-slate-600 font-medium">Manage student batches and academic cycles</p>
    </div>
    <a href="{{ route('batches.create') }}" class="btn-premium">
        <i class="fas fa-plus mr-2 opacity-70"></i> Create New Batch
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Batch Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th class="text-right">Operations</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $batch)
                <tr class="group">
                    <td>
                        <div class="font-bold text-slate-800 tracking-tight">{{ $batch->batch_name }}</div>
                    </td>
                    <td>
                        <div class="text-sm font-medium text-slate-600">{{ $batch->start_date ? \Carbon\Carbon::parse($batch->start_date)->format('M d, Y') : 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="text-sm font-medium text-slate-600">{{ $batch->end_date ? \Carbon\Carbon::parse($batch->end_date)->format('M d, Y') : 'N/A' }}</div>
                    </td>
                    <td>
                        @if($batch->is_current)
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                            Current Batch
                        </span>
                        @else
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-slate-100 text-slate-500 border border-slate-200">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('batches.edit', $batch) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('batches.destroy', $batch) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" onclick="return confirm('Are you sure you want to delete this batch?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20 italic font-bold text-slate-400">
                        No batches found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($batches->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $batches->links() }}
    </div>
    @endif
</div>
@endsection
