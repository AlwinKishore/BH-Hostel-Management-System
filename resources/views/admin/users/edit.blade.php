@extends('layouts.admin')

@section('header', 'Modify Personnel')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('users.index') }}" class="hover:text-indigo-600 transition-colors">Access Control</a>
        <span>/</span>
        <span class="text-slate-800">Edit Profile</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Edit Access Profile</h3>
            <p class="text-sm text-slate-600 font-medium">Update system operator credentials and data</p>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="form-label-premium">Personnel Full Name</label>
                    <input type="text" name="name" id="name" class="form-input-premium" value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="form-label-premium">Electronic Mail Address</label>
                    <input type="email" name="email" id="email" class="form-input-premium" value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100/50">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-info-circle text-indigo-500 mr-3"></i>
                        <span class="text-[10px] font-black uppercase text-indigo-700 tracking-widest">Security Update</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="password" class="form-label-premium">New Password <span class="text-[9px] lowercase font-normal italic opacity-60">(Leave blank to keep current)</span></label>
                            <input type="password" name="password" id="password" class="form-input-premium" placeholder="••••••••">
                            @error('password') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label-premium">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input-premium" placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('users.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Discard Changes
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-check-double mr-2 opacity-70"></i> Update Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
