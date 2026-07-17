<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    public function index()
    {
        $remarks = Remark::latest()->paginate(10);
        return view('admin.remarks.index', compact('remarks'));
    }

    public function create()
    {
        $hostellers = \App\Models\Hosteller::all();
        return view('admin.remarks.create', compact('hostellers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hosteller_id' => 'required|exists:hostellers,id',
            'remarks' => 'required|string',
        ]);
        
        $validated['created_by'] = auth()->id();
        Remark::create($validated);

        return redirect()->route('remarks.index')->with('success', 'Remark added successfully.');
    }

    public function edit(Remark $remark)
    {
        $hostellers = \App\Models\Hosteller::all();
        return view('admin.remarks.edit', compact('remark', 'hostellers'));
    }

    public function update(Request $request, Remark $remark)
    {
        $validated = $request->validate([
            'hosteller_id' => 'required|exists:hostellers,id',
            'remarks' => 'required|string',
        ]);

        $validated['updated_by'] = auth()->id();
        $remark->update($validated);

        return redirect()->route('remarks.index')->with('success', 'Remark updated successfully.');
    }

    public function destroy(Remark $remark)
    {
        $remark->delete();
        return redirect()->route('remarks.index')->with('success', 'Remark deleted successfully.');
    }
}
