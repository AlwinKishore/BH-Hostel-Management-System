@extends('layouts.admin')

@section('header', 'Register Personnel')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center space-x-2 text-slate-500 mb-6 font-bold text-[10px] uppercase tracking-widest">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Portal</a>
        <span>/</span>
        <a href="{{ route('users.index') }}" class="hover:text-indigo-600 transition-colors">Access Control</a>
        <span>/</span>
        <span class="text-slate-800">New Registration</span>
    </div>

    <div class="glass-card p-10 border-none shadow-2xl shadow-slate-200/60">
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">System Access Credentialing</h3>
            <p class="text-sm text-slate-600 font-medium">Provision new administrative or staff credentials</p>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="username" class="form-label-premium">Personnel Username</label>
                    <input type="text" name="username" id="username" class="form-input-premium" placeholder="Enter operator username" value="{{ old('username') }}" required>
                    @error('username') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="form-label-premium">Electronic Mail Address</label>
                    <input type="email" name="email" id="email" class="form-input-premium" placeholder="operator@bh.com" value="{{ old('email') }}" required>
                    @error('email') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="password" class="form-label-premium">Access Password</label>
                        <input type="password" name="password" id="password" class="form-input-premium" placeholder="••••••••" required>
                        @error('password') <p class="mt-2 text-[10px] font-black uppercase text-rose-500 ml-4 tracking-wider">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label-premium">Re-authenticate Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input-premium" placeholder="••••••••" required>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6 pt-10 border-t border-slate-100">
                <a href="{{ route('users.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel Operation
                </a>
                <button type="submit" class="btn-premium px-10 py-4">
                    <i class="fas fa-key mr-2 opacity-70"></i> Finish Registration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
