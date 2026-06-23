@extends('layouts.admin')

@section('header', 'Process Complaint')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center space-x-2 text-gray-400 mb-6 font-medium text-sm">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('complaints.index') }}" class="hover:text-indigo-600 transition-colors">Complaints</a>
        <span>/</span>
        <span class="text-gray-800">Process</span>
    </div>

    <div class="glass-card">
        <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-gray-50 bg-opacity-50 p-4 rounded-lg border border-gray-100 mb-4">
                    <div class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Original Complaint</div>
                    <div class="text-sm font-bold text-gray-800 mb-2">{{ $complaint->title }}</div>
                    <div class="text-xs text-gray-600 leading-relaxed">{{ $complaint->description }}</div>
                    <div class="mt-2 text-[10px] text-gray-400">By {{ $complaint->student->name }} on {{ $complaint->created_at->format('M d, Y') }}</div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <input type="hidden" name="student_id" value="{{ $complaint->student_id }}">
                        <input type="hidden" name="category" value="{{ $complaint->category }}">
                        <input type="hidden" name="title" value="{{ $complaint->title }}">
                        <input type="hidden" name="description" value="{{ $complaint->description }}">
                        
                        <label for="status" class="block text-sm font-medium text-gray-700">Resolution Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="dismissed" {{ $complaint->status == 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="resolution_notes" class="block text-sm font-medium text-gray-700">Resolution Notes / Response</label>
                    <textarea name="resolution_notes" id="resolution_notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Explain how the issue was addressed...">{{ $complaint->resolution_notes }}</textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('complaints.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium">
                    Update Complaint
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
