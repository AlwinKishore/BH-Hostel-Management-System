@extends('layouts.admin')

@section('header', 'System Personnel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Access Control</h3>
        <p class="text-sm text-slate-600 font-medium">Manage administrative privileges and system operators</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn-premium">
        <i class="fas fa-user-shield mr-2 opacity-70"></i> Register New User
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>User Identity</th>
                    <th>Electronic Mail</th>
                    <th>Account Status</th>
                    <th>Last Active</th>
                    <th class="text-right">Operations</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="group">
                    <td>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black mr-4 shadow-lg shadow-indigo-600/20">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="font-bold text-slate-800 tracking-tight">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm font-medium text-slate-600">{{ $user->email }}</div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                            Active Session
                        </span>
                    </td>
                    <td>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-tighter italic">
                            {{ $user->updated_at->diffForHumans() }}
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('users.edit', $user) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-user-pen"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" onclick="return confirm('Revoke user access and delete account?')">
                                    <i class="fas fa-user-xmark"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20 italic font-bold text-slate-400">
                        No system users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
