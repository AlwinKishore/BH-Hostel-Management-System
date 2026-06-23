<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Building;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $building_id = $request->get('building_id');
        
        $buildings = Building::active()->get();
        
        $query = Student::with(['attendances' => function($q) use ($date) {
            $q->where('date', $date);
        }]);

        if ($building_id) {
            $query->whereHas('room', function($q) use ($building_id) {
                $q->where('building_id', $building_id);
            });
        }

        $students = $query->where('status', 'active')->get();

        return view('admin.attendance.index', compact('students', 'date', 'buildings', 'building_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        $date = $request->date;

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $student_id, 'date' => $date],
                ['status' => $status]
            );
        }

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
