<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with(['room.building', 'student'])->latest()->paginate(15);
        return view('admin.maintenance.index', compact('requests'));
    }

    public function create()
    {
        $rooms = Room::with('building')->get();
        $students = Student::all();
        return view('admin.maintenance.create', compact('rooms', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'student_id' => 'nullable|exists:students,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
            'scheduled_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
        ]);

        if (!isset($validated['status'])) {
            $validated['status'] = 'pending';
        }

        MaintenanceRequest::create($validated);

        return redirect()->route('maintenance.index')->with('success', 'Maintenance request created.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        return view('admin.maintenance.show', compact('maintenance'));
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        $rooms = Room::with('building')->get();
        $students = Student::all();
        return view('admin.maintenance.edit', [
            'maintenanceRequest' => $maintenance,
            'rooms' => $rooms,
            'students' => $students
        ]);
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'student_id' => 'nullable|exists:students,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
            'scheduled_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
        ]);

        if (!isset($validated['status'])) {
            $validated['status'] = $maintenance->status;
        }

        $maintenance->update($validated);

        return redirect()->route('maintenance.index')->with('success', 'Maintenance request updated.');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenance.index')->with('success', 'Maintenance request deleted.');
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $currentStatus = $maintenance->status;
        $nextStatus = $currentStatus;

        if ($request->has('status')) {
            $nextStatus = $request->status;
        } else {
            // Automatic progression
            $stages = ['pending', 'in_progress', 'completed'];
            $currentIndex = array_search($currentStatus, $stages);
            
            if ($currentIndex !== false && $currentIndex < count($stages) - 1) {
                $nextStatus = $stages[$currentIndex + 1];
            }
        }

        $maintenance->update(['status' => $nextStatus]);

        return back()->with('success', 'Maintenance stage updated to ' . str_replace('_', ' ', $nextStatus));
    }
}
