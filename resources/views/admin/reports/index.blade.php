@extends('layouts.admin')

@section('header', 'Report Engine')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Data Intelligence</h3>
        <p class="text-sm text-slate-600 font-medium">Generate, export and analyze system-wide forensics</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <!-- Report Configuration -->
    <div class="lg:col-span-2">
        <div class="glass-card p-10 border-none shadow-2xl shadow-indigo-100/30">
            <h4 class="text-lg font-black text-slate-800 mb-8 border-b border-slate-100 pb-4">Report Builder Configuration</h4>
            
            <form action="{{ route('reports.export') }}" method="GET" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="report_type" class="form-label-premium">Report Classification</label>
                        <select name="type" id="report_type" class="form-input-premium appearance-none">
                            <option value="occupancy">Occupancy & Room Utilization</option>
                            <option value="financial">Financial Performance & Revenue</option>
                            <option value="attendance">Student Attendance Audit</option>
                            <option value="students">Active Resident Directory</option>
                            <option value="maintenance">Maintenance Operations Log</option>
                        </select>
                    </div>

                    <div>
                        <label for="format" class="form-label-premium">Output Architecture</label>
                        <select name="format" id="format" class="form-input-premium appearance-none">
                            <option value="excel">Microsoft Excel (.xlsx)</option>
                            <option value="csv">Comma Separated Values (.csv)</option>
                            <option value="pdf">Portable Document Format (.pdf)</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="form-label-premium">Temporal Range: From</label>
                        <input type="date" name="from" id="date_from" class="form-input-premium" value="{{ date('Y-m-01') }}">
                    </div>

                    <div>
                        <label for="date_to" class="form-label-premium">Temporal Range: To</label>
                        <input type="date" name="to" id="date_to" class="form-input-premium" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-8 border-t border-slate-50">
                    <div class="flex items-center text-[10px] font-black uppercase text-slate-400 tracking-widest italic">
                        <i class="fas fa-shield-halved mr-3"></i>
                        Authorized secure data export
                    </div>
                    <button type="submit" class="btn-premium px-12 py-4">
                        <i class="fas fa-file-export mr-3"></i> Generate & Download Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Insights -->
    <div class="space-y-8">
        <div class="glass-card p-8 bg-indigo-600 text-white shadow-indigo-200">
            <div class="flex items-center justify-between mb-6">
                <i class="fas fa-microchip text-2xl opacity-50"></i>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-white/10 px-3 py-1 rounded-full">Automated Insight</span>
            </div>
            <h5 class="text-xl font-black mb-2 leading-tight tracking-tight">Revenue Analysis</h5>
            <p class="text-indigo-100 text-sm font-medium mb-6">Financial reports now include automated month-over-month variance detection.</p>
            <a href="{{ route('reports.financial') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-white hover:opacity-70 transition-opacity">
                View Internal Matrix <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="glass-card p-8 border-none shadow-xl shadow-slate-100 border-l-4 border-emerald-500">
            <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4">Export Protocol</h5>
            <ul class="space-y-3">
                <li class="flex items-start text-xs text-slate-600 font-bold leading-relaxed">
                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 mr-3"></i>
                    All exports are timestamped for audit logging.
                </li>
                <li class="flex items-start text-xs text-slate-600 font-bold leading-relaxed">
                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 mr-3"></i>
                    Financial records are calculated in real-time.
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="mb-10">
    <h4 class="text-lg font-black text-slate-800 mb-2">Historical Exports</h4>
    <p class="text-xs text-slate-600 font-bold uppercase tracking-widest">Recent generated intelligence logs</p>
</div>

<div class="glass-card overflow-hidden border-none shadow-xl shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Generation Date</th>
                    <th>Report Classification</th>
                    <th>Date Parameters</th>
                    <th>Data Integrity</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="group">
                    <td>
                        <div class="font-bold text-slate-800">{{ now()->format('d M, Y') }}</div>
                        <div class="text-[10px] text-slate-500 font-black uppercase tracking-tight mt-0.5">{{ now()->format('H:i A') }}</div>
                    </td>
                    <td>
                        <div class="text-[10px] font-black uppercase tracking-widest text-indigo-600 px-3 py-1 bg-indigo-50 rounded-lg inline-block border border-indigo-100 italic">
                            Operational Occupancy
                        </div>
                    </td>
                    <td>
                        <div class="text-xs font-bold text-slate-700">All Time Summary</div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700">
                            Verified
                        </span>
                    </td>
                    <td class="text-right">
                        <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-download"></i>
                        </button>
                    </td>
                </tr>
                <tr class="group">
                    <td>
                        <div class="font-bold text-slate-800">{{ now()->subDay()->format('d M, Y') }}</div>
                        <div class="text-[10px] text-slate-500 font-black uppercase tracking-tight mt-0.5">14:23 PM</div>
                    </td>
                    <td>
                        <div class="text-[10px] font-black uppercase tracking-widest text-emerald-600 px-3 py-1 bg-emerald-50 rounded-lg inline-block border border-emerald-100 italic">
                            Financial Matrix
                        </div>
                    </td>
                    <td>
                        <div class="text-xs font-bold text-slate-700">Jan 2026 - Feb 2026</div>
                    </td>
                    <td>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700">
                            Verified
                        </span>
                    </td>
                    <td class="text-right">
                        <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-download"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
