@extends('layouts.admin')

@section('header', 'Edit Student Details')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('students.index') }}" class="hover:text-indigo-600 transition-colors">Students</a>
        <span>/</span>
        <span class="text-slate-800">Edit Profile</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Modify Student Profile</h3>
            <p class="text-sm text-slate-600 font-medium">Update residency records and personal documentation</p>
        </div>

        <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-12">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Personal Info Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                            <i class="fas fa-user-edit text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Personal Identification</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="form-label-premium">Student Full Name</label>
                            <input type="text" name="name" id="name" class="form-input-premium" value="{{ old('name', $student->name) }}" required>
                            @error('name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="form-label-premium">Electronic Mail</label>
                                <input type="email" name="email" id="email" class="form-input-premium" value="{{ old('email', $student->email) }}" required>
                                @error('email') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="phone" class="form-label-premium">Mobile Number</label>
                                <input type="text" name="phone" id="phone" class="form-input-premium" value="{{ old('phone', $student->phone) }}" required>
                                @error('phone') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="id_proof_type" class="form-label-premium">Credential Type</label>
                                <div class="relative group">
                                    <select name="id_proof_type" id="id_proof_type" class="form-input-premium appearance-none">
                                        <option value="Aadhaar" {{ old('id_proof_type', $student->id_proof_type) == 'Aadhaar' ? 'selected' : '' }}>National ID / Aadhaar</option>
                                        <option value="Passport" {{ old('id_proof_type', $student->id_proof_type) == 'Passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="Driving License" {{ old('id_proof_type', $student->id_proof_type) == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                        <option value="Student ID" {{ old('id_proof_type', $student->id_proof_type) == 'Student ID' ? 'selected' : '' }}>University ID</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="id_proof_number" class="form-label-premium">Credential Serial #</label>
                                <input type="text" name="id_proof_number" id="id_proof_number" class="form-input-premium" value="{{ old('id_proof_number', $student->id_proof_number) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Allocation Info Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-600/20">
                            <i class="fas fa-bed text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Facility Allocation</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="room_id" class="form-label-premium">Designated Residential Unit</label>
                            <div class="relative group">
                                <select name="room_id" id="room_id" class="form-input-premium appearance-none" required>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" data-price="{{ $room->price }}" {{ old('room_id', $student->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_number }} - {{ $room->building->name }} (Floor {{ $room->floor }}) — {{ $room->capacity - $room->students_count }} beds free
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-search-location text-xs"></i>
                                </div>
                            </div>
                            @error('room_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <!-- Financial Summary Section -->
                        <div class="bg-indigo-50/30 rounded-3xl p-8 border border-indigo-100/50 space-y-4">
                            <div class="flex justify-between items-center text-[10px] font-black uppercase text-indigo-400 tracking-widest">
                                <span>Financial Records</span>
                                <span>Status: <span id="payment-status-badge">{{ $student->payment_status }}</span></span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm font-bold text-slate-700">
                                    <span>Base Room Rent</span>
                                    <span id="room-price-display">₹0.00</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold text-slate-700">
                                    <span>Recurring Service Fees</span>
                                    @php $otherFees = \App\Models\FeeStructure::sum('amount'); @endphp
                                    <span id="other-fees-display" data-fees="{{ $otherFees }}">₹{{ number_format($otherFees, 2) }}</span>
                                </div>
                                <div class="h-px bg-indigo-100 my-2"></div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-black uppercase text-slate-800 tracking-wider">Total Monthly Obligation</span>
                                    <span id="total-bill-display" class="text-xl font-black text-indigo-600">₹0.00</span>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-[10px] font-black uppercase text-emerald-600 tracking-wider">Total Amount Paid</span>
                                    <span class="text-sm font-black text-emerald-600">₹{{ number_format($student->paid_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="joining_date" class="form-label-premium">Enrollment / Joining Date</label>
                                <input type="date" name="joining_date" id="joining_date" class="form-input-premium" value="{{ old('joining_date', $student->joining_date) }}">
                            </div>
                            <div>
                                <label for="status" class="form-label-premium">Residency Status</label>
                                <div class="relative group">
                                    <select name="status" id="status" class="form-input-premium appearance-none">
                                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active Resident</option>
                                        <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="alumni" {{ old('status', $student->status) == 'alumni' ? 'selected' : '' }}>Alumni / Checked Out</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-signal text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('students.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Discard Changes
                </a>
                <button type="submit" class="btn-premium px-12 py-4 shadow-xl shadow-indigo-600/20">
                    <i class="fas fa-save mr-2 opacity-70"></i> Update Records
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomIdSelect = document.getElementById('room_id');
        const roomPriceDisplay = document.getElementById('room-price-display');
        const otherFeesDisplay = document.getElementById('other-fees-display');
        const totalBillDisplay = document.getElementById('total-bill-display');

        function updateBill() {
            const selectedOption = roomIdSelect.options[roomIdSelect.selectedIndex];
            const roomPrice = selectedOption && selectedOption.value ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
            const otherFees = parseFloat(otherFeesDisplay.getAttribute('data-fees')) || 0;
            const total = roomPrice + otherFees;

            roomPriceDisplay.textContent = '$' + roomPrice.toFixed(2);
            totalBillDisplay.textContent = '$' + total.toFixed(2);
        }

        roomIdSelect.addEventListener('change', updateBill);
        updateBill(); // Initial run
    });
</script>
@endsection
