<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Models\Student;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::where('status', 'active')->count(),
            'total_rooms' => Room::count(),
            'vacant_rooms' => Room::where('status', 'vacant')->count(),
            'maintenance_pending' => MaintenanceRequest::where('status', 'pending')->count(),
            'revenue_this_month' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'total_buildings' => Building::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
