@extends('layouts.admin')

@section('header', 'Edit Payment Record')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('payments.index') }}" class="hover:text-indigo-600 transition-colors">Payments</a>
        <span>/</span>
        <span class="text-slate-800">Edit Transaction</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Transaction: {{ $payment->receipt_number }}</h3>
            <p class="text-sm text-slate-600 font-medium">Update financial records, status updates, or reconciliation notes</p>
        </div>

        <form action="{{ route('payments.update', $payment) }}" method="POST" class="space-y-12">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Transaction Details Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-600/20">
                            <i class="fas fa-edit text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Transaction Identification</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="student_id" class="form-label-premium">Resident Student</label>
                            <div class="relative group">
                                <select name="student_id" id="student_id" class="form-input-premium appearance-none" required>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }} — ID: {{ $student->id_proof_number ?? 'N/A' }} (Loc: {{ $student->room?->room_number ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-search text-xs"></i>
                                </div>
                            </div>
                            @error('student_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="amount" class="form-label-premium">Payment Amount</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <input type="number" step="0.01" name="amount" id="amount" class="form-input-premium pl-12" value="{{ old('amount', $payment->amount) }}" required>
                                </div>
                                @error('amount') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="payment_date" class="form-label-premium">Transaction Date</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-input-premium" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>
                                @error('payment_date') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="transaction_id" class="form-label-premium">Bank Reference / TXN ID</label>
                            <input type="text" name="transaction_id" id="transaction_id" class="form-input-premium" value="{{ old('transaction_id', $payment->transaction_id) }}">
                            @error('transaction_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Processing & Logistics Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                            <i class="fas fa-cog text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Processing & Meta</h4>
                    </div>
                    
                    <div class="space-y-6">
                            <div>
                                <label for="payment_method" class="form-label-premium">Payment Channel</label>
                                <div class="relative group">
                                    <select name="payment_method" id="payment_method" class="form-input-premium appearance-none">
                                        <option value="Cash" {{ old('payment_method', $payment->payment_method) == 'Cash' ? 'selected' : '' }}>Hard Cash</option>
                                        <option value="Bank Transfer" {{ old('payment_method', $payment->payment_method) == 'Bank Transfer' ? 'selected' : '' }}>Direct Bank Transfer</option>
                                        <option value="Online (UPI/Card)" {{ old('payment_method', $payment->payment_method) == 'Online (UPI/Card)' ? 'selected' : '' }}>UPI / Digital Card</option>
                                        <option value="Cheque" {{ old('payment_method', $payment->payment_method) == 'Cheque' ? 'selected' : '' }}>Bank Cheque</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-wallet text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="remarks" class="form-label-premium">Operational Remarks</label>
                            <textarea name="remarks" id="remarks" rows="4" class="form-input-premium resize-none" placeholder="Add specific notes about the transaction reconcile">{{ old('remarks', $payment->remarks) }}</textarea>
                            @error('remarks') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('payments.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard Changes
                </a>
                <button type="submit" class="btn-premium px-12 py-4 shadow-xl shadow-indigo-600/20">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Receipt
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
