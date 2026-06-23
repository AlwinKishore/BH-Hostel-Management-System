@extends('layouts.admin')

@section('header', 'Record New Expense')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('expenses.index') }}" class="hover:text-indigo-600 transition-colors">Expenses</a>
        <span>/</span>
        <span class="text-slate-800">Record Outflow</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Financial Outflow Record</h3>
            <p class="text-sm text-slate-600 font-medium">Log vendor payments, maintenance costs, or general operational expenses</p>
        </div>

        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="title" class="form-label-premium">Expense Title / Description</label>
                    <input type="text" name="title" id="title" class="form-input-premium" placeholder="e.g. Plumbing Repairs, Office Supplies" value="{{ old('title') }}" required>
                </div>

                <div class="md:col-span-2">
                    <label class="form-label-premium">Expense Classification</label>
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                        @foreach(['vendor' => 'fas fa-store', 'maintenance' => 'fas fa-tools', 'utilities' => 'fas fa-faucet', 'salary' => 'fas fa-user-tie', 'miscellaneous' => 'fas fa-box'] as $cat => $icon)
                        <label class="cursor-pointer group">
                            <input type="radio" name="category" value="{{ $cat }}" class="hidden peer" {{ old('category') == $cat || ($loop->first && !old('category')) ? 'checked' : '' }}>
                            <div class="p-4 rounded-2xl border-2 border-transparent bg-slate-50 flex flex-col items-center justify-center transition-all peer-checked:border-indigo-600 peer-checked:bg-white peer-checked:shadow-lg group-hover:bg-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center mb-2 shadow-sm group-hover:scale-110 transition-transform text-indigo-500">
                                    <i class="{{ $icon }}"></i>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">{{ $cat }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="amount" class="form-label-premium">Transaction Amount</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-rose-500 transition-colors">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-input-premium pl-12" placeholder="0.00" value="{{ old('amount') }}" required>
                    </div>
                </div>

                <div>
                    <label for="date" class="form-label-premium">Transaction Date</label>
                    <input type="date" name="date" id="date" class="form-input-premium" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>

                <div>
                    <label for="paid_to" class="form-label-premium">Payee / Recipient Name</label>
                    <input type="text" name="paid_to" id="paid_to" class="form-input-premium" placeholder="Entity or Person Name" value="{{ old('paid_to') }}">
                </div>

                <div>
                    <label for="payment_method" class="form-label-premium">Settlement Mode</label>
                    <input type="text" name="payment_method" id="payment_method" class="form-input-premium" placeholder="e.g. Bank Transfer, Cash, Check" value="{{ old('payment_method') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="form-label-premium">Transaction Status Tracking</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" name="status" value="paid" class="hidden peer" checked>
                            <div class="p-5 rounded-2xl border-2 border-transparent bg-emerald-50/50 flex items-center justify-between transition-all peer-checked:border-emerald-500 peer-checked:bg-white">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white mr-4 shadow-lg shadow-emerald-500/20">
                                        <i class="fas fa-check-double text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">Settled & Fully Paid</p>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Funds have been disbursed</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-all">
                                    <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="status" value="pending" class="hidden peer">
                            <div class="p-5 rounded-2xl border-2 border-transparent bg-amber-50/50 flex items-center justify-between transition-all peer-checked:border-amber-500 peer-checked:bg-white">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white mr-4 shadow-lg shadow-amber-500/20">
                                        <i class="fas fa-hourglass-half text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">Pending Clearance</p>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Invoice recorded, payment pending</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-500 flex items-center justify-center transition-all">
                                    <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="form-label-premium">Supplemental Notes</label>
                    <textarea name="description" id="description" rows="3" class="form-input-premium py-4" placeholder="Brief context about this expenditure...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('expenses.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-check-circle mr-2 opacity-70"></i> Save Expense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
