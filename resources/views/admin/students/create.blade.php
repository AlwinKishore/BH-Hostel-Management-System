@extends('layouts.admin')

@section('header', 'Register New Student')

@section('content')
<div class="max-w-9xl mx-auto">
    <div class="flex items-center space-x-3 text-slate-500 mb-10 font-bold text-[10px] uppercase tracking-[0.2em]">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('students.index') }}" class="hover:text-indigo-600 transition-colors">Hostellers</a>
        <span>/</span>
        <span class="text-slate-800">New Hosteller</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60 transition-transform duration-500 hover:scale-[1.01]">
        <div class="mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Register New Hosteller</h3>
            <p class="text-sm text-slate-600 font-medium">Capture hosteller particulars and initialize facility allocation</p>
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
                            <label for="student_name" class="form-label-premium">Hosteller Full Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="student_name" id="student_name" class="form-input-premium" value="{{ old('student_name') }}" required>
                            @error('student_name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hostel_no" class="form-label-premium">Hostel Number <span class="text-rose-500">*</span></label>
                                <input type="number" name="hostel_no" id="hostel_no" class="form-input-premium" value="{{ old('hostel_no') }}" required>
                                @error('hostel_no') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="dno" class="form-label-premium">D.No <span class="text-rose-500">*</span></label>
                                <input type="text" name="dno" id="dno" class="form-input-premium" value="{{ old('dno') }}" required>
                                @error('dno') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="academic_year_id" class="form-label-premium">Academic Year <span class="text-rose-500">*</span></label>
                                <select name="academic_year_id" id="academic_year_id" class="form-input-premium appearance-none" required>
                                    <option value="">Select Academic Year</option>
                                    @foreach($academicYears as $academicYear)
                                        <option value="{{ $academicYear->id }}" {{ old('academic_year_id') == $academicYear->id ? 'selected' : '' }}>{{ $academicYear->name }}</option>
                                    @endforeach
                                </select>
                                @error('academic_year_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="batch_id" class="form-label-premium">Batch <span class="text-rose-500">*</span></label>
                                <select name="batch_id" id="batch_id" class="form-input-premium appearance-none" required>
                                    <option value="">Select Batch</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" data-academic-year-id="{{ $batch->academic_year_id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->batch_name }}</option>
                                    @endforeach
                                </select>
                                @error('batch_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
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
                            <label for="room_id" class="form-label-premium">Designated Room <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <select name="room_id" id="room_id" class="form-input-premium appearance-none" required>
                                    <option value="">Select Room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Room {{ $room->room_no }} (Floor {{ $room->floor }}) — {{ max(0, $room->accommodation - $room->hostellers_count) }} beds free
                                        </option>
                                    @endforeach
                                </select>
                                <!-- <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-search-location text-xs"></i>
                                </div> -->
                            </div>
                            @error('room_id') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <!-- Dynamic Room Details Container -->
                        <div id="room-details-container" class="hidden mt-6 p-5 bg-slate-50 border border-slate-200 rounded-2xl shadow-inner">
                            <div id="room-capacity-info" class="text-sm mb-4"></div>
                            <div id="room-hostellers-list" class="space-y-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('students.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-600 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-12 py-4 shadow-xl shadow-indigo-600/20">
                    <i class="fas fa-user-plus mr-2 opacity-70"></i> Save Hosteller
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const academicYearSelect = document.getElementById('academic_year_id');
        const batchSelect = document.getElementById('batch_id');
        
        // Clone all original options (except the first placeholder)
        const allBatchOptions = Array.from(batchSelect.options).slice(1).map(opt => opt.cloneNode(true));
        const placeholderOption = batchSelect.options[0].cloneNode(true);

        function filterBatches() {
            const selectedYearId = academicYearSelect.value;
            const currentSelection = batchSelect.value;
            
            // Clear current options
            batchSelect.innerHTML = '';
            batchSelect.appendChild(placeholderOption);

            let hasValidSelection = false;

            allBatchOptions.forEach(option => {
                if (!selectedYearId || option.getAttribute('data-academic-year-id') === selectedYearId) {
                    batchSelect.appendChild(option.cloneNode(true));
                    if (option.value === currentSelection) {
                        hasValidSelection = true;
                    }
                }
            });

            if (hasValidSelection) {
                batchSelect.value = currentSelection;
            } else {
                batchSelect.value = '';
            }
        }

        academicYearSelect.addEventListener('change', filterBatches);
        // Initial filter on load
        filterBatches();

        // Dynamic Room Details Logic
        const roomSelect = document.getElementById('room_id');
        const roomDetailsContainer = document.getElementById('room-details-container');
        const roomCapacityInfo = document.getElementById('room-capacity-info');
        const roomHostellersList = document.getElementById('room-hostellers-list');
        
        const roomsData = @json($rooms);

        function updateRoomDetails() {
            const selectedRoomId = parseInt(roomSelect.value);
            if (!selectedRoomId) {
                roomDetailsContainer.classList.add('hidden');
                return;
            }

            const room = roomsData.find(r => r.id === selectedRoomId);
            if (!room) {
                roomDetailsContainer.classList.add('hidden');
                return;
            }

            roomDetailsContainer.classList.remove('hidden');
            
            const available = Math.max(0, room.accommodation - room.hostellers_count);
            const filled = room.hostellers_count;
            
            roomCapacityInfo.innerHTML = `
                <div class="flex items-center space-x-4">
                    <div class="px-3 py-1 bg-white rounded-lg shadow-sm border border-slate-100">
                        <span class="text-emerald-600 font-black">${available} Available</span>
                    </div>
                    <div class="px-3 py-1 bg-white rounded-lg shadow-sm border border-slate-100">
                        <span class="text-amber-600 font-black">${filled} Filled</span>
                    </div>
                </div>
            `;

            if (filled > 0 && room.hostellers && room.hostellers.length > 0) {
                let hostellersHtml = '<h5 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 mt-4">Current Occupants</h5>';
                room.hostellers.forEach(occupant => {
                    hostellersHtml += `
                        <div class="flex items-center p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold mr-3">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-xs font-bold text-slate-800">${occupant.student_name}</div>
                                <div class="text-[10px] font-medium text-slate-500">D.No: ${occupant.dno || 'N/A'} | Hostel: ${occupant.hostel_no}</div>
                            </div>
                            <div class="text-[9px] uppercase font-black tracking-widest text-indigo-500 bg-indigo-50 px-2 py-1 rounded-md">
                                ${occupant.batch ? occupant.batch.batch_name : 'No Batch'}
                            </div>
                        </div>
                    `;
                });
                roomHostellersList.innerHTML = hostellersHtml;
            } else {
                roomHostellersList.innerHTML = '<div class="text-xs italic text-slate-400 mt-2">This room is currently empty.</div>';
            }
        }

        roomSelect.addEventListener('change', updateRoomDetails);
        updateRoomDetails(); // Run on load in case old value is selected
    });
</script>
@endsection
