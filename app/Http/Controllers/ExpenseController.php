<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->paginate(15);
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'paid_to' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:paid,pending,cancelled',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'paid_to' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:paid,pending,cancelled',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function updateStatus(Request $request, Expense $expense)
    {
        $newStatus = $expense->status == 'paid' ? 'pending' : 'paid';
        $expense->update(['status' => $newStatus]);

        return back()->with('success', 'Expense marked as ' . $newStatus);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense record deleted.');
    }
}
