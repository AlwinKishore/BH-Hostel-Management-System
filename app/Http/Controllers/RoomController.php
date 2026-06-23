<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('building')->latest()->paginate(8);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $buildings = Building::where('status', 'active')->get();
        return view('admin.rooms.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $building = Building::findOrFail($request->building_id);

        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'floor' => 'required|integer|min:0|max:'.$building->total_floors,
            'capacity' => 'required|integer|min:1|max:'.$building->capacity,
            'type' => 'required|in:single,double,triple,dormitory',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied,maintenance',
        ], [
            'floor.max' => 'The selected building only has ' . $building->total_floors . ' floors.',
            'capacity.max' => 'The room capacity cannot exceed the total building capacity of ' . $building->capacity . '.',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $buildings = Building::where('status', 'active')->get();
        return view('admin.rooms.edit', compact('room', 'buildings'));
    }

    public function update(Request $request, Room $room)
    {
        $building = Building::findOrFail($request->building_id);

        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'floor' => 'required|integer|min:0|max:'.$building->total_floors,
            'capacity' => 'required|integer|min:1|max:'.$building->capacity,
            'type' => 'required|in:single,double,triple,dormitory',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied,maintenance',
        ], [
            'floor.max' => 'The selected building only has ' . $building->total_floors . ' floors.',
            'capacity.max' => 'The room capacity cannot exceed the total building capacity of ' . $building->capacity . '.',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
