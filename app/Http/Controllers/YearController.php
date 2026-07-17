<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index()
    {
        $years = Year::with('batch')->latest()->paginate(10);
        return view('admin.years.index', compact('years'));
    }

    public function create()
    {
        $batches = \App\Models\Batch::latest()->get();
        return view('admin.years.create', compact('batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year_name' => 'required|string|max:50|unique:years,year_name',
            'batch_id' => 'nullable|exists:batches,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id();

        Year::create($validated);

        return redirect()->route('years.index')->with('success', 'Academic Year created successfully.');
    }

    public function edit(Year $year)
    {
        $batches = \App\Models\Batch::latest()->get();
        return view('admin.years.edit', compact('year', 'batches'));
    }

    public function update(Request $request, Year $year)
    {
        $validated = $request->validate([
            'year_name' => 'required|string|max:50|unique:years,year_name,' . $year->id,
            'batch_id' => 'nullable|exists:batches,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id();

        $year->update($validated);

        return redirect()->route('years.index')->with('success', 'Academic Year updated successfully.');
    }

    public function destroy(Year $year)
    {
        $year->delete();
        return redirect()->route('years.index')->with('success', 'Academic Year deleted successfully.');
    }
}
