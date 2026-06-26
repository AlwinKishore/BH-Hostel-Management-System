<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('category')->latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.rooms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:20|unique:rooms,room_no',
            'room_category' => 'nullable|exists:categories,id',
            'floor' => 'nullable|string|max:20',
            'accommodation' => 'required|integer|min:1|max:20',
            'is_full' => 'boolean',
            'is_available' => 'boolean'
        ]);

        $validated['is_full'] = $request->has('is_full');
        $validated['is_available'] = $request->has('is_available');
        $validated['created_by'] = auth()->id();

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.rooms.edit', compact('room', 'categories'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:20|unique:rooms,room_no,' . $room->id,
            'room_category' => 'nullable|exists:categories,id',
            'floor' => 'nullable|string|max:20',
            'accommodation' => 'required|integer|min:1|max:20',
            'is_full' => 'boolean',
            'is_available' => 'boolean'
        ]);

        $validated['is_full'] = $request->has('is_full');
        $validated['is_available'] = $request->has('is_available');
        $validated['updated_by'] = auth()->id();

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
