@extends('layouts.admin')

@section('header', 'Financial Performance')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center space-x-2 text-gray-400 font-medium text-sm">
        <a href="{{ route('reports.index') }}" class="hover:text-indigo-600 transition-colors">Reports</a>
        <span>/</span>
        <span class="text-gray-800">Financial Insights</span>
    </div>
    
    <form action="{{ route('reports.financial') }}" method="GET" class="flex items-center space-x-2">
        <label class="text-sm font-bold text-gray-600">Year:</label>
        <select name="year" onchange="this.form.submit()" class="rounded-md border-gray-300 py-1 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @for($i = date('Y'); $i >= date('Y')-5; $i--)
                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 glass-card p-6">
        <h4 class="font-bold text-gray-800 mb-6">Monthly Revenue Growth</h4>
        <div class="overflow-hidden">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th class="text-right">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $months = [
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                        ];
                        $grand_total = 0;
                    @endphp
                    @foreach($months as $num => $name)
                    @php
                        $month_data = $monthly_revenue->firstWhere('month', $num);
                        $amount = $month_data ? $month_data->total : 0;
                        $grand_total += $amount;
                    @endphp
                    <tr class="{{ $num == date('n') ? 'bg-indigo-50 bg-opacity-30' : '' }}">
                        <td class="font-medium text-gray-700">{{ $name }}</td>
                        <td class="text-right font-bold text-gray-900">₹{{ number_format($amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50">
                        <td class="font-bold text-gray-800">Annual Total</td>
                        <td class="text-right font-extrabold text-indigo-600 text-lg">₹{{ number_format($grand_total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="glass-card p-6 h-fit">
        <h4 class="font-bold text-gray-800 mb-4 text-center">Summary ({{ $year }})</h4>
        <div class="space-y-6">
            <div class="text-center p-6 bg-indigo-50 bg-opacity-50 rounded-2xl border border-indigo-100">
                <div class="text-xs text-indigo-600 font-bold uppercase tracking-widest mb-1">Total Collected</div>
                <div class="text-3xl font-black text-indigo-700">₹{{ number_format($grand_total, 0) }}</div>
            </div>
            
            <div class="bg-white bg-opacity-50 p-4 rounded-xl">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-600">Avg / Month</span>
                    <span class="text-sm font-bold text-gray-800">₹{{ number_format($grand_total / 12, 2) }}</span>
                </div>
                <div class="w-full bg-gray-100 h-1.5 rounded-full">
                    <div class="bg-blue-400 h-1.5 rounded-full" style="width: 70%"></div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-[10px] text-gray-400 leading-tight">Payments are recorded based on the local time of entry. Financial reports are generated in INR equivalent.</p>
            </div>
        </div>
    </div>
</div>
@endsection
