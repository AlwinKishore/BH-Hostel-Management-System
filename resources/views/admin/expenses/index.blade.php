@extends('layouts.admin')

@section('header', 'Expense Management')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Expense Ledger</h3>
            <p class="text-sm text-slate-500 font-medium">Tracking operational costs, vendor payments, and maintenance overhead</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="btn-premium px-6">
            <i class="fas fa-plus-circle mr-2 opacity-70"></i> Record Expense
        </a>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="glass-card p-6 border-l-4 border-l-rose-500">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Total Outflow</p>
            <h4 class="text-2xl font-black text-slate-800">₹{{ number_format(\App\Models\Expense::sum('amount'), 2) }}</h4>
        </div>
        <div class="glass-card p-6 border-l-4 border-l-amber-500">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Pending Invoices</p>
            <h4 class="text-2xl font-black text-slate-800">₹{{ number_format(\App\Models\Expense::where('status', 'pending')->sum('amount'), 2) }}</h4>
        </div>
        <div class="glass-card p-6 border-l-4 border-l-indigo-500">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Maintenance Total</p>
            <h4 class="text-2xl font-black text-slate-800">₹{{ number_format(\App\Models\Expense::where('category', 'maintenance')->sum('amount'), 2) }}</h4>
        </div>
    </div>

    <div class="glass-card overflow-hidden border-none shadow-2xl shadow-slate-200/60">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Transaction Details</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Category</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Amount</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 mr-4 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800 tracking-tight">{{ $expense->title }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Paid to: {{ $expense->paid_to ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full bg-slate-100 text-slate-600">
                                {{ str_replace('_', ' ', $expense->category) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-600">
                            {{ $expense->date->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-sm font-black text-rose-600">-₹{{ number_format($expense->amount, 2) }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <form action="{{ route('expenses.updateStatus', $expense) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full transition-all border
                                    {{ $expense->status == 'paid' ? 'bg-emerald-100 text-emerald-700 border-emerald-200 hover:bg-emerald-200' : 
                                       'bg-amber-100 text-amber-700 border-amber-200 hover:bg-amber-200' }}">
                                    <i class="fas {{ $expense->status == 'paid' ? 'fa-check' : 'fa-clock' }} mr-1"></i>
                                    {{ $expense->status }}
                                </button>
                            </form>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('expenses.edit', $expense) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Archive this transaction?')">
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
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-200">
                                    <i class="fas fa-receipt text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No expense records found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($expenses->hasPages())
        <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
            {{ $expenses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
