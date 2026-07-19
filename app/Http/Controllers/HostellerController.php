<?php

namespace App\Http\Controllers;

use App\Models\Hosteller;
use Illuminate\Http\Request;

class HostellerController extends Controller
{
    public function index()
    {
        $students = Hosteller::latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $rooms = \App\Models\Room::with(['hostellers.batch'])->withCount('hostellers')->where('is_available', true)->get()->filter(function($room) {
            return $room->hostellers_count < $room->accommodation;
        })->values();
        $academicYears = \App\Models\AcademicYear::all();
        $batches = \App\Models\Batch::all();
        return view('admin.students.create', compact('rooms', 'academicYears', 'batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:150',
            'hostel_no' => 'required|integer|unique:hostellers,hostel_no',
            'dno' => 'nullable|string|max:50|unique:hostellers,dno',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'batch_id' => 'nullable|exists:batches,id',
            'room_id' => 'nullable|exists:rooms,id',
        ]);
        
        $validated['created_by'] = auth()->id();
        Hosteller::create($validated);

        return redirect()->route('students.index')->with('success', 'Student registered successfully.');
    }

    public function edit(Hosteller $student)
    {
        $rooms = \App\Models\Room::with(['hostellers.batch'])->withCount('hostellers')->where('is_available', true)->get()->filter(function($room) use ($student) {
            return $room->hostellers_count < $room->accommodation || $room->id == $student->room_id;
        })->values();
        $academicYears = \App\Models\AcademicYear::all();
        $batches = \App\Models\Batch::all();
        return view('admin.students.edit', ['student' => $student, 'rooms' => $rooms, 'academicYears' => $academicYears, 'batches' => $batches]);
    }

    public function update(Request $request, Hosteller $student)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:150',
            'hostel_no' => 'required|integer|unique:hostellers,hostel_no,' . $student->id,
            'dno' => 'nullable|string|max:50|unique:hostellers,dno,' . $student->id,
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'batch_id' => 'nullable|exists:batches,id',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $validated['updated_by'] = auth()->id();
        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Hosteller $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
