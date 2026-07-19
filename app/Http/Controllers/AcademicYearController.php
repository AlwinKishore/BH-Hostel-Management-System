<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academic_years = AcademicYear::latest()->paginate(10);
        return view('admin.academic_years.index', compact('academic_years'));
    }

    public function create()
    {
        return view('admin.academic_years.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean'
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $exactOneYear = $startDate->copy()->addYear()->format('Y-m-d');
        $oneYearMinusDay = $startDate->copy()->addYear()->subDay()->format('Y-m-d');
        
        if (!in_array($endDate->format('Y-m-d'), [$exactOneYear, $oneYearMinusDay])) {
            return back()->withErrors(['end_date' => 'The academic year duration must be exactly 1 year (e.g. 2025-06-19 to 2026-06-18).'])->withInput();
        }

        $overlapping = AcademicYear::where(function ($query) use ($validated) {
            $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                  ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                  ->orWhere(function ($q) use ($validated) {
                      $q->where('start_date', '<=', $validated['start_date'])
                        ->where('end_date', '>=', $validated['end_date']);
                  });
        })->exists();

        if ($overlapping) {
            return back()->withErrors(['start_date' => 'The academic year dates overlap with an existing academic year.'])->withInput();
        }

        $validated['is_current'] = $request->has('is_current');
        $validated['created_by'] = auth()->id();

        if ($validated['is_current']) {
            AcademicYear::where('is_current', true)->update(['is_current' => false]);
        }

        AcademicYear::create($validated);

        return redirect()->route('academic-years.index')->with('success', 'Academic Year created successfully.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic_years.edit', ['academic_year' => $academicYear]);
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:academic_years,name,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean'
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $exactOneYear = $startDate->copy()->addYear()->format('Y-m-d');
        $oneYearMinusDay = $startDate->copy()->addYear()->subDay()->format('Y-m-d');
        
        if (!in_array($endDate->format('Y-m-d'), [$exactOneYear, $oneYearMinusDay])) {
            return back()->withErrors(['end_date' => 'The academic year duration must be exactly 1 year (e.g. 2025-06-19 to 2026-06-18).'])->withInput();
        }

        $overlapping = AcademicYear::where('id', '!=', $academicYear->id)->where(function ($query) use ($validated) {
            $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                  ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                  ->orWhere(function ($q) use ($validated) {
                      $q->where('start_date', '<=', $validated['start_date'])
                        ->where('end_date', '>=', $validated['end_date']);
                  });
        })->exists();

        if ($overlapping) {
            return back()->withErrors(['start_date' => 'The academic year dates overlap with an existing academic year.'])->withInput();
        }

        $validated['is_current'] = $request->has('is_current');
        $validated['updated_by'] = auth()->id();

        if ($validated['is_current']) {
            AcademicYear::where('id', '!=', $academicYear->id)->update(['is_current' => false]);
        }

        $academicYear->update($validated);

        return redirect()->route('academic-years.index')->with('success', 'Academic Year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('academic-years.index')->with('success', 'Academic Year deleted successfully.');
    }
}
