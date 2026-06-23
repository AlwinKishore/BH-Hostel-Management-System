@extends('layouts.admin')

@section('header', 'Maintenance Requests')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Maintenance</h3>
        <p class="text-sm text-slate-600 font-medium">Facility upkeep and emergency repair logistics</p>
    </div>
    <a href="{{ route('maintenance.create') }}" class="btn-premium">
        <i class="fas fa-hammer-war mr-2 opacity-70"></i> Post New Request
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Service Identification</th>
                    <th>Station</th>
                    <th>Priority Level</th>
                    <th>Workflow</th>
                    <th>Originator</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr class="group">
                    <td>
                        <div class="font-bold text-slate-800 leading-tight">{{ $req->title }}</div>
                        <div class="text-[10px] text-slate-600 font-black uppercase tracking-tighter mt-1 max-w-[200px] truncate">{{ $req->description }}</div>
                    </td>
                    <td>
                        <div class="inline-flex items-center px-2 py-1 bg-slate-50 border border-slate-100 rounded-lg">
                            <i class="fas fa-location-dot text-[10px] text-slate-500 mr-2"></i>
                            <span class="text-xs font-bold text-slate-700">Room {{ $req->room?->room_number ?? 'Ext' }}</span>
                        </div>
                        <div class="text-[9px] text-slate-600 font-black uppercase tracking-widest mt-1 pl-1">{{ $req->room?->building?->name }}</div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full shadow-inner
                            {{ $req->priority == 'urgent' ? 'bg-rose-500 text-white shadow-rose-200' : 
                              ($req->priority == 'high' ? 'bg-orange-500 text-white shadow-orange-200' : 
                              ($req->priority == 'medium' ? 'bg-sky-500 text-white shadow-sky-200' : 'bg-slate-400 text-white shadow-slate-200')) }}">
                            {{ $req->priority }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('maintenance.updateStatus', $req) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            @if($req->status == 'pending')
                                <button type="submit" class="group/btn flex items-center px-4 py-1.5 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm border border-amber-100">
                                    <i class="fas fa-play mr-2 text-[8px] group-hover/btn:translate-x-1 transition-transform"></i>
                                    Pending / Start
                                </button>
                            @elseif($req->status == 'in_progress')
                                <button type="submit" class="group/btn flex items-center px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-500 hover:text-white transition-all shadow-sm border border-indigo-100">
                                    <i class="fas fa-check mr-2 text-[8px] group-hover/btn:scale-125 transition-transform"></i>
                                    In Progress / Complete
                                </button>
                            @else
                                <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-xl border border-emerald-200">
                                    <i class="fas fa-circle-check mr-2 text-[8px]"></i>
                                    {{ $req->status }}
                                </span>
                            @endif
                        </form>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 mr-2">
                                {{ substr($req->student?->name ?? 'S', 0, 1) }}
                            </div>
                            <div class="text-xs font-bold text-slate-700">{{ $req->student?->name ?? 'System Gen' }}</div>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('maintenance.edit', $req) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-screwdriver-wrench"></i>
                            </a>
                            <form action="{{ route('maintenance.destroy', $req) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition-colors" onclick="return confirm('Archive this request?')">
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
                                <i class="fas fa-toolbox text-2xl text-slate-400"></i>
                            </div>
                            <span class="font-bold text-slate-500">Maintenance logs are clear.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($requests->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection
