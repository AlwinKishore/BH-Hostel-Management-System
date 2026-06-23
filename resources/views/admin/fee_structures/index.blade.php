@extends('layouts.admin')

@section('header', 'Prices Palette (Fee Structures)')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Prices Palette</h3>
            <p class="text-sm text-slate-500 font-medium">Configure global charges including food, electricity, and amenity fees</p>
        </div>
        <a href="{{ route('fee-structures.create') }}" class="btn-premium px-6">
            <i class="fas fa-plus-circle mr-2 opacity-70"></i> Define New Price
        </a>
    </div>

    <div class="glass-card overflow-hidden border-none shadow-2xl shadow-slate-200/60">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Charge Name</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Target Segment</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Frequency</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Monthly Amount</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($structures as $fee)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <p class="text-sm font-black text-slate-800 tracking-tight">{{ $fee->name }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-600">
                            {{ $fee->room_type ?? 'All Rooms' }} 
                            @if($fee->building)
                                <span class="text-[10px] text-slate-400 ml-2">({{ $fee->building->name }})</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full bg-slate-100 text-slate-600">
                                {{ $fee->frequency }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-sm font-black text-indigo-600">₹{{ number_format($fee->amount, 2) }}</p>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('fee-structures.edit', $fee) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('fee-structures.destroy', $fee) }}" method="POST" class="inline" onsubmit="return confirm('Remove this fee structure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-200">
                                    <i class="fas fa-tags text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Pricing palette is empty</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($structures->hasPages())
        <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
            {{ $structures->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
