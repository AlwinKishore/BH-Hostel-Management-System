<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Hosteller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        
        $query = Hosteller::with(['attendances' => function($q) use ($date) {
            $q->where('attendance_date', $date);
        }, 'academicYear', 'batch', 'room']);

        $students = $query->get();
        
        $groupedStudents = $students->sortBy(function($student) {
            return ($student->academicYear->name ?? 'Z') . '-' . ($student->batch->batch_name ?? 'Z');
        })->groupBy(function($student) {
            $year = $student->academicYear ? $student->academicYear->name : 'Unassigned Year';
            $batch = $student->batch ? $student->batch->batch_name : 'Unassigned Batch';
            return $year . ' — ' . $batch;
        });

        return view('admin.attendance.index', compact('groupedStudents', 'date'));
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

        if ($request->has('attendance')) {
            foreach ($request->attendance as $hosteller_id => $status) {
                Attendance::updateOrCreate(
                    ['hosteller_id' => $hosteller_id, 'attendance_date' => $date],
                    [
                        'is_present' => ($status === 'present'),
                        'submitted_by' => auth()->id(),
                        'created_by' => auth()->id()
                    ]
                );
            }
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
