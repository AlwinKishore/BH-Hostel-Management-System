<?php

namespace App\Http\Controllers;

use App\Models\Hosteller;
use Illuminate\Http\Request;

class HostellerController extends Controller
{
    public function index(Request $request)
    {
        $query = Hosteller::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('hostel_no', 'like', "%{$search}%")
                  ->orWhere('dno', 'like', "%{$search}%");
            });
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $academicYears = \App\Models\AcademicYear::all();
        
        return view('admin.students.index', compact('students', 'academicYears'));
    }

    public function create()
    {
        $rooms = \App\Models\Room::with(['hostellers.batch'])->withCount('hostellers')->where('is_available', true)->get()->filter(function($room) {
            return $room->hostellers_count < $room->accommodation;
        })->values();
        $academicYears = \App\Models\AcademicYear::where('is_current', true)->get();
        $batches = \App\Models\Batch::where('is_active', true)->get();
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
        $academicYears = \App\Models\AcademicYear::where('is_current', true)->get();
        $batches = \App\Models\Batch::where('is_active', true)->get();
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
