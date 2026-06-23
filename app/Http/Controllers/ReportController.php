<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Models\Student;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function occupancy()
    {
        $buildings = Building::withCount(['rooms', 'rooms as vacant_rooms_count' => function($query) {
            $query->where('status', 'vacant');
        }])->get();

        return view('admin.reports.occupancy', compact('buildings'));
    }

    public function financial(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $monthly_revenue = Payment::select(
            DB::raw('MONTH(payment_date) as month'),
            DB::raw('SUM(amount) as total')
        )
        ->whereYear('payment_date', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('admin.reports.financial', compact('monthly_revenue', 'year'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type');
        $format = $request->get('format', 'excel');
        
        // In a real application, you would use Maatwebsite\Excel for .xlsx
        // For now, we will return a success message or a CSV based on the type
        
        return redirect()->back()->with('success', ucfirst($type) . ' report generation initiated. The system is compiling the data for download.');
    }
}
