@extends('layouts.admin')

@section('header', 'Register Complaint')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center space-x-2 text-gray-400 mb-6 font-medium text-sm">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('complaints.index') }}" class="hover:text-indigo-600 transition-colors">Complaints</a>
        <span>/</span>
        <span class="text-gray-800">New Entry</span>
    </div>

    <div class="glass-card">
        <form action="{{ route('complaints.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student Name</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} (Room: {{ $student->room?->room_number ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="Food">Food / Canteen</option>
                            <option value="Security">Security</option>
                            <option value="Roommate">Roommate Issue</option>
                            <option value="Noise">Noise / Disturbance</option>
                            <option value="Hostel Rules">Hostel Rules Violation</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Initial Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="pending" selected>Pending</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Complaint Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Brief summary of the issue" required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Detailed Explanation</label>
                    <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Please describe the issue in detail..." required></textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('complaints.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium">
                    Register Complaint
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
