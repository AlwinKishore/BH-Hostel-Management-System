<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\Building;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $structures = FeeStructure::with('building')->latest()->paginate(15);
        return view('admin.fee_structures.index', compact('structures'));
    }

    public function create()
    {
        $buildings = Building::where('status', 'active')->get();
        return view('admin.fee_structures.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:monthly,quarterly,yearly',
            'building_id' => 'nullable|exists:buildings,id',
            'description' => 'nullable|string',
        ]);

        FeeStructure::create($validated);

        return redirect()->route('fee-structures.index')->with('success', 'Fee structure created.');
    }

    public function edit(FeeStructure $feeStructure)
    {
        $buildings = Building::where('status', 'active')->get();
        return view('admin.fee_structures.edit', compact('feeStructure', 'buildings'));
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:monthly,quarterly,yearly',
            'building_id' => 'nullable|exists:buildings,id',
            'description' => 'nullable|string',
        ]);

        $feeStructure->update($validated);

        return redirect()->route('fee-structures.index')->with('success', 'Fee structure updated.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return redirect()->route('fee-structures.index')->with('success', 'Fee structure deleted.');
    }
}
