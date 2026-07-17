<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::latest()->paginate(10);
        return view('admin.leaves.index', compact('leaves'));
    }

    public function create()
    {
        $hostellers = \App\Models\Hosteller::all();
        return view('admin.leaves.create', compact('hostellers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hosteller_id' => 'required|exists:hostellers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);
        
        $validated['created_by'] = auth()->id();
        Leave::create($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave request created successfully.');
    }

    public function edit(Leave $leaf) // $leaf because Laravel pluralization handles 'leaves' as 'leaf' in parameter bindings
    {
        $hostellers = \App\Models\Hosteller::all();
        return view('admin.leaves.edit', ['leave' => $leaf, 'hostellers' => $hostellers]);
    }

    public function update(Request $request, Leave $leaf)
    {
        $validated = $request->validate([
            'hosteller_id' => 'required|exists:hostellers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
            'is_approved' => 'nullable|boolean',
        ]);

        $validated['is_approved'] = $request->has('is_approved');
        $validated['updated_by'] = auth()->id();
        
        $leaf->update($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }

    public function destroy(Leave $leaf)
    {
        $leaf->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }
}
