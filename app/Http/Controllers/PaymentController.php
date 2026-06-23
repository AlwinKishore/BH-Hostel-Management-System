<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student.room.building')->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->get();
        return view('admin.payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id',
            'remarks' => 'nullable|string',
        ]);

        $validated['status'] = 'paid'; // Automatically mark as paid when recording manually
        $validated['receipt_number'] = 'REC-' . strtoupper(uniqid());

        $payment = Payment::create($validated);
        $this->updateStudentBilling($payment->student_id);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        return view('admin.payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $oldStudentId = $payment->student_id;
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id,' . $payment->id,
            'remarks' => 'nullable|string',
        ]);

        if (!$request->has('status')) {
            $validated['status'] = 'paid';
        }

        $payment->update($validated);
        $this->updateStudentBilling($payment->student_id);
        if ($oldStudentId != $payment->student_id) {
            $this->updateStudentBilling($oldStudentId);
        }

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $studentId = $payment->student_id;
        $payment->delete();
        $this->updateStudentBilling($studentId);

        return redirect()->route('payments.index')->with('success', 'Payment record deleted successfully.');
    }

    private function updateStudentBilling($studentId)
    {
        $student = Student::find($studentId);
        if (!$student) return;

        $totalPaid = Payment::where('student_id', $studentId)
            ->where('status', 'paid')
            ->sum('amount');

        $status = 'due';
        if ($totalPaid >= $student->total_bill && $student->total_bill > 0) {
            $status = 'paid';
        } elseif ($totalPaid > 0) {
            $status = 'partially_paid';
        }

        $student->update([
            'paid_amount' => $totalPaid,
            'payment_status' => $status
        ]);
    }
}
