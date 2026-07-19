<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('academicYear')->latest()->paginate(10);
        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        $academic_years = \App\Models\AcademicYear::latest()->get();
        return view('admin.batches.create', compact('academic_years'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:50|unique:batches,batch_name',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id();

        Batch::create($validated);

        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        $academic_years = \App\Models\AcademicYear::latest()->get();
        return view('admin.batches.edit', compact('batch', 'academic_years'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:50|unique:batches,batch_name,' . $batch->id,
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id();

        $batch->update($validated);

        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }
}
