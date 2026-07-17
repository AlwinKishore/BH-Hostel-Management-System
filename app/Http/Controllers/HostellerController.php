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
        $rooms = \App\Models\Room::withCount('hostellers')->where('is_available', true)->get();
        $batches = \App\Models\Batch::all();
        $years = \App\Models\Year::all();
        return view('admin.students.create', compact('rooms', 'batches', 'years'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:150',
            'hostel_no' => 'required|integer',
            'dno' => 'nullable|string|max:50',
            'batch_id' => 'nullable|exists:batches,id',
            'year_id' => 'nullable|exists:years,id',
            'room_id' => 'nullable|exists:rooms,id',
        ]);
        
        $validated['created_by'] = auth()->id();
        Hosteller::create($validated);

        return redirect()->route('students.index')->with('success', 'Student registered successfully.');
    }

    public function edit(Hosteller $hosteller)
    {
        $rooms = \App\Models\Room::withCount('hostellers')->where('is_available', true)->get();
        $batches = \App\Models\Batch::all();
        $years = \App\Models\Year::all();
        return view('admin.students.edit', ['student' => $hosteller, 'rooms' => $rooms, 'batches' => $batches, 'years' => $years]);
    }

    public function update(Request $request, Hosteller $hosteller)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:150',
            'hostel_no' => 'required|integer',
            'dno' => 'nullable|string|max:50',
            'batch_id' => 'nullable|exists:batches,id',
            'year_id' => 'nullable|exists:years,id',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $validated['updated_by'] = auth()->id();
        $hosteller->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Hosteller $hosteller)
    {
        $hosteller->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
