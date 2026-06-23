<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-white text-center">Register</h2>
        <div class="w-12 h-1 bg-indigo-500 mx-auto mt-2 rounded-full"></div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="form-label-premium">Full Name</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                    <i class="fas fa-user-circle"></i>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-input-premium pl-11" placeholder="Manager Name">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label-premium">Email Address</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                    <i class="fas fa-envelope"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input-premium pl-11" placeholder="admin@hapi.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label-premium">Password</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                    <i class="fas fa-key"></i>
                </div>
                <input id="password" type="password" name="password" required class="form-input-premium pl-11" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label-premium">Repeat Password</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input-premium pl-11" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <div class="pt-4">
            <button type="submit" class="btn-primary w-full shadow-2xl shadow-indigo-600/30">
                <span>Create Manager Account</span>
                <i class="fas fa-user-plus ml-2 text-[10px]"></i>
            </button>
        </div>

        <div class="pt-6 text-center">
            <p class="text-slate-500 text-xs font-semibold">
                Already registered? 
                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-black ml-1 transition-colors underline decoration-2 underline-offset-4">
                    Sign In
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
