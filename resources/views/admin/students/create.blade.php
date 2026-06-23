@extends('layouts.admin')

@section('header', 'Register New Student')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('students.index') }}" class="hover:text-indigo-600 transition-colors">Students</a>
        <span>/</span>
        <span class="text-slate-800">New Registration</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Onboard New Resident</h3>
            <p class="text-sm text-slate-600 font-medium">Capture student particulars and initialize facility allocation</p>
        </div>

        <form action="{{ route('students.store') }}" method="POST" class="space-y-12">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Personal Info Section -->
                <div class="space-y-8">
                    <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                            <i class="fas fa-user text-xs"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Personal Identification</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="form-label-premium">Student Full Name</label>
                            <input type="text" name="name" id="name" class="form-input-premium" placeholder="e.g. Johnathan Doe" value="{{ old('name') }}" required>
                            @error('name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="form-label-premium">Electronic Mail</label>
                                <input type="email" name="email" id="email" class="form-input-premium" placeholder="student@example.com" value="{{ old('email') }}" required>
                                @error('email') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="phone" class="form-label-premium">Mobile Number</label>
                                <input type="text" name="phone" id="phone" class="form-input-premium" placeholder="+1 (555) 000-0000" value="{{ old('phone') }}" required>
                                @error('phone') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="id_proof_type" class="form-label-premium">Credential Type</label>
                                <div class="relative group">
                                    <select name="id_proof_type" id="id_proof_type" class="form-input-premium appearance-none">
                                        <option value="Aadhaar">National ID / Aadhaar</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driving License">Driving License</option>
                                        <option value="Student ID">University ID</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="id_proof_number" class="form-label-premium">Credential Serial #</label>
                                <input type="text" name="id_proof_number" id="id_proof_number" class="form-input-premium" placeholder="ID Number" value="{{ old('id_proof_number') }}">
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
                                    <option value="">Select Room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" data-price="{{ $room->price }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
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
                        <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 space-y-4">
                            <div class="flex justify-between items-center text-[10px] font-black uppercase text-slate-400 tracking-widest">
                                <span>Itemized Billing</span>
                                <span>Estimated Amount</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm font-bold text-slate-700">
                                    <span>Room Rent (Monthly)</span>
                                    <span id="room-price-display">₹0.00</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold text-slate-700">
                                    <span>Food & Recurring Services</span>
                                    @php $otherFees = \App\Models\FeeStructure::sum('amount'); @endphp
                                    <span id="other-fees-display" data-fees="{{ $otherFees }}">₹{{ number_format($otherFees, 2) }}</span>
                                </div>
                                <div class="h-px bg-slate-200 my-2"></div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-black uppercase text-slate-800 tracking-wider">Total Monthly Bill</span>
                                    <span id="total-bill-display" class="text-xl font-black text-indigo-600">₹0.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="joining_date" class="form-label-premium">Enrollment / Joining Date</label>
                                <input type="date" name="joining_date" id="joining_date" class="form-input-premium" value="{{ old('joining_date', date('Y-m-d')) }}">
                            </div>
                            <div>
                                <label for="status" class="form-label-premium">Residency Status</label>
                                <div class="relative group">
                                    <select name="status" id="status" class="form-input-premium appearance-none">
                                        <option value="active" selected>Active Resident</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="alumni">Alumni / Checked Out</option>
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
                    Discard Operation
                </a>
                <button type="submit" class="btn-premium px-12 py-4 shadow-xl shadow-indigo-600/20">
                    <i class="fas fa-user-plus mr-2 opacity-70"></i> Finish Registration
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
