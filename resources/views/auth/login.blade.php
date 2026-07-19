<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-white text-center">Login</h2>
        <div class="w-12 h-1 bg-white-300 mx-auto mt-2 rounded-full"></div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label-premium">Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                    <i class="fas fa-envelope"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input-premium pl-11" placeholder="admin@bh.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5 ml-1">
                <label for="password" class="text-sm font-semibold text-slate-300">Password</label>
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                    <i class="fas fa-lock"></i>
                </div>
                <input id="password" type="password" name="password" required class="form-input-premium pl-11" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded bg-white/5 border-white/20 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 transition-all cursor-pointer" name="remember">
                <span class="ms-3 text-xs font-bold text-slate-500 group-hover:text-slate-300 transition-colors">Remember my session</span>
            </label>
        </div>

        <div>
            <button type="submit" class="btn-primary w-full shadow-2xl shadow-indigo-600/30">
                <span>Sign In to Panel</span>
                <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
            </button>
        </div>


    </form>
</x-guest-layout>
