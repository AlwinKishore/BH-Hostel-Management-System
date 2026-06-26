<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::latest()->paginate(10);
        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        return view('admin.batches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:100|unique:batches,batch_name',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean'
        ]);

        $validated['is_current'] = $request->has('is_current');
        $validated['created_by'] = auth()->id();

        if ($validated['is_current']) {
            Batch::where('is_current', true)->update(['is_current' => false]);
        }

        Batch::create($validated);

        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        return view('admin.batches.edit', compact('batch'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:100|unique:batches,batch_name,' . $batch->id,
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean'
        ]);

        $validated['is_current'] = $request->has('is_current');
        $validated['updated_by'] = auth()->id();

        if ($validated['is_current']) {
            Batch::where('id', '!=', $batch->id)->update(['is_current' => false]);
        }

        $batch->update($validated);

        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }
}
