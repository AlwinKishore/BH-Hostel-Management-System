<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Student;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('student')->latest()->paginate(15);
        return view('admin.complaints.index', compact('complaints'));
    }

    public function create()
    {
        $students = Student::active()->get();
        return view('admin.complaints.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,resolved,closed,dismissed',
        ]);

        Complaint::create($validated);

        return redirect()->route('complaints.index')->with('success', 'Complaint registered successfully.');
    }

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        $students = Student::all();
        return view('admin.complaints.edit', compact('complaint', 'students'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,resolved,closed,dismissed',
            'resolution_notes' => 'nullable|string',
        ]);

        if ($validated['status'] == 'resolved' && !$complaint->resolved_at) {
            $validated['resolved_at'] = now();
        }

        $complaint->update($validated);

        return redirect()->route('complaints.index')->with('success', 'Complaint status updated.');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('complaints.index')->with('success', 'Complaint deleted.');
    }
}
