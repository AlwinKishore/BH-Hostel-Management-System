<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::latest()->paginate(10);
        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'total_floors' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:0',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Building::create($validated);

        return redirect()->route('buildings.index')->with('success', 'Building created successfully.');
    }

    public function show(Building $building)
    {
        return view('admin.buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'total_floors' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:0',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $building->update($validated);

        return redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Building deleted successfully.');
    }
}
