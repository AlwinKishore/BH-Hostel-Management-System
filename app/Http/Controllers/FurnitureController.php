<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use App\Models\Room;
use Illuminate\Http\Request;

class FurnitureController extends Controller
{
    public function index()
    {
        $furniture = Furniture::with('room.building')->latest()->paginate(20);
        return view('admin.furniture.index', compact('furniture'));
    }

    public function create()
    {
        $rooms = Room::with('building')->where('status', 'vacant')->get();
        return view('admin.furniture.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'code' => 'required|string|unique:furniture,code',
            'room_id' => 'nullable|exists:rooms,id',
            'condition' => 'required|in:new,good,damaged,repairable',
            'status' => 'required|in:available,assigned,broken,maintenance',
        ]);

        Furniture::create($validated);

        return redirect()->route('furniture.index')->with('success', 'Furniture item added successfully.');
    }

    public function show(Furniture $furniture)
    {
        return view('admin.furniture.show', compact('furniture'));
    }

    public function edit(Furniture $furniture)
    {
        $rooms = Room::with('building')
            ->where('status', 'vacant')
            ->orWhere('id', $furniture->room_id)
            ->get();
        return view('admin.furniture.edit', compact('furniture', 'rooms'));
    }

    public function update(Request $request, Furniture $furniture)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'code' => 'required|string|unique:furniture,code,' . $furniture->id,
            'room_id' => 'nullable|exists:rooms,id',
            'condition' => 'required|in:new,good,damaged,repairable',
            'status' => 'required|in:available,assigned,broken,maintenance',
        ]);

        $furniture->update($validated);

        return redirect()->route('furniture.index')->with('success', 'Furniture item updated successfully.');
    }

    public function destroy(Furniture $furniture)
    {
        $furniture->delete();
        return redirect()->route('furniture.index')->with('success', 'Furniture item deleted successfully.');
    }
}
