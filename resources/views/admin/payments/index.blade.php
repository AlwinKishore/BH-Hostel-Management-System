@extends('layouts.admin')

@section('header', 'Payment History')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Finances</h3>
        <p class="text-sm text-slate-600 font-medium">Monitor revenue and student payment history</p>
    </div>
    <a href="{{ route('payments.create') }}" class="btn-premium">
        <i class="fas fa-file-invoice-dollar mr-2 opacity-70"></i> Record Payment
    </a>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Ref No.</th>
                    <th>Payee</th>
                    <th>Value</th>
                    <th>Transaction Date</th>
                    <th>Mode</th>
                    <th>Verification</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="group">
                    <td>
                        <div class="font-mono text-[11px] font-black text-slate-600 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                            {{ $payment->receipt_number }}
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-slate-800 leading-tight">{{ $payment->student->name }}</div>
                        <div class="text-[10px] text-slate-600 font-black uppercase tracking-wider mt-0.5">Room {{ $payment->student->room?->room_number ?? 'General' }}</div>
                    </td>
                    <td>
                        <div class="text-sm font-black text-indigo-600 bg-indigo-50/50 px-3 py-1 rounded-xl border border-indigo-100/50 inline-block">
                            ₹{{ number_format($payment->amount, 2) }}
                        </div>
                    </td>
                    <td>
                        <div class="text-sm font-bold text-slate-700">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center text-xs font-black text-slate-600 uppercase tracking-tighter">
                            <i class="fas fa-circle-dot text-[8px] mr-2 text-slate-400"></i>
                            {{ $payment->payment_method }}
                        </div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                            {{ $payment->status == 'paid' ? 'bg-emerald-100 text-emerald-700' : 
                               ($payment->status == 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('payments.edit', $payment) }}" class="p-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-receipt"></i>
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition-colors" onclick="return confirm('Void this payment record?')">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-20">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-vault text-2xl text-slate-400"></i>
                            </div>
                            <span class="font-bold text-slate-500">No transactions recorded yet.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($payments->hasPages())
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
