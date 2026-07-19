<?php

namespace App\Http\Controllers;

use App\Models\Hosteller;
use App\Models\Room;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return view('admin.search.index', [
                'query' => $query,
                'students' => collect(),
                'rooms' => collect()
            ]);
        }

        $students = Hosteller::where('student_name', 'LIKE', "%{$query}%")
            ->orWhere('hostel_no', 'LIKE', "%{$query}%")
            ->orWhere('dno', 'LIKE', "%{$query}%")
            ->get();

        $rooms = Room::where('room_no', 'LIKE', "%{$query}%")
            ->get();

        return view('admin.search.index', compact('query', 'students', 'rooms'));
    }
}
