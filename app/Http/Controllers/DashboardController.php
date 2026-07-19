<?php
namespace App\Http\Controllers;

use App\Models\Hosteller;
use App\Models\Room;
use App\Models\Leave;
use App\Models\Attendance;
use App\Models\Batch;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Hosteller::count(),
            'total_rooms' => Room::count(),
            'vacant_rooms' => Room::where('is_available', true)->count(),
            'leaves_pending' => Leave::where('status', 'pending')->count(),
            'todays_attendance' => Attendance::whereDate('attendance_date', today())->count(),
            'active_batches' => Batch::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

