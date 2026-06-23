<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Room;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('room.building')->latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        // Show rooms that are vacant OR partially occupied (students_count < capacity)
        $rooms = Room::with('building')
            ->withCount('students')
            ->where('status', '!=', 'maintenance')
            ->get()
            ->filter(function($room) {
                return $room->students_count < $room->capacity;
            });

        return view('admin.students.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:20',
            'id_proof_number' => 'nullable|string',
            'id_proof_type' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
            'joining_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,alumni',
        ]);

        // Calculate Bill
        $room = Room::findOrFail($validated['room_id']);
        $otherFees = \App\Models\FeeStructure::sum('amount');
        $validated['total_bill'] = $room->price + $otherFees;
        $validated['payment_status'] = 'due';

        $student = Student::create($validated);

        if ($student->room_id) {
            $room = Room::withCount('students')->find($student->room_id);
            if ($room->students_count >= $room->capacity) {
                $room->update(['status' => 'occupied']);
            }
        }

        return redirect()->route('students.index')->with('success', 'Student registered successfully. Total Bill: $' . number_format($validated['total_bill'], 2));
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        // Show rooms that have space OR is the current room
        $rooms = Room::with('building')
            ->withCount('students')
            ->where('status', '!=', 'maintenance')
            ->get()
            ->filter(function($room) use ($student) {
                return ($room->students_count < $room->capacity) || ($room->id == $student->room_id);
            });

        return view('admin.students.edit', compact('student', 'rooms'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'required|string|max:20',
            'id_proof_number' => 'nullable|string',
            'id_proof_type' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
            'joining_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,alumni',
        ]);

        $oldRoomId = $student->room_id;
        
        // Recalculate Bill if room changed
        if ($oldRoomId != $validated['room_id']) {
            $room = Room::findOrFail($validated['room_id']);
            $otherFees = \App\Models\FeeStructure::sum('amount');
            $validated['total_bill'] = $room->price + $otherFees;
            
            // Re-evaluate payment status
            $totalPaid = \App\Models\Payment::where('student_id', $student->id)->where('status', 'paid')->sum('amount');
            $status = 'due';
            if ($totalPaid >= $validated['total_bill'] && $validated['total_bill'] > 0) {
                $status = 'paid';
            } elseif ($totalPaid > 0) {
                $status = 'partially_paid';
            }
            $validated['payment_status'] = $status;
            $validated['paid_amount'] = $totalPaid;
        }

        $student->update($validated);

        // Update status for the old room
        if ($oldRoomId && $oldRoomId != $student->room_id) {
            $oldRoom = Room::withCount('students')->find($oldRoomId);
            if ($oldRoom && $oldRoom->students_count < $oldRoom->capacity) {
                $oldRoom->update(['status' => 'vacant']);
            }
        }

        // Update status for the new room
        if ($student->room_id) {
            $newRoom = Room::withCount('students')->find($student->room_id);
            if ($newRoom->students_count >= $newRoom->capacity) {
                $newRoom->update(['status' => 'occupied']);
            } else {
                $newRoom->update(['status' => 'vacant']);
            }
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $roomId = $student->room_id;
        $student->delete();

        if ($roomId) {
            $otherStudents = Student::where('room_id', $roomId)->exists();
            if (!$otherStudents) {
                Room::where('id', $roomId)->update(['status' => 'vacant']);
            }
        }

        return redirect()->route('students.index')->with('success', 'Student record deleted successfully.');
    }
}
