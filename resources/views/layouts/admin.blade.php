<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BH Hostel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    backgroundImage: {
                        'mesh': "radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%)",
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer components {
            .glass-sidebar {
                @apply bg-slate-900/95 backdrop-blur-xl border-r border-white/5;
            }
            .nav-link-premium {
                @apply flex items-center px-6 py-3.5 text-slate-400 hover:text-white hover:bg-white/5 transition-all duration-200 rounded-2xl mx-3 mb-1 font-medium;
            }
            .nav-link-premium.active {
                @apply bg-indigo-600 text-white shadow-lg shadow-indigo-600/30;
            }
            .glass-card {
                @apply bg-white/80 backdrop-blur-md border border-slate-200 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300;
            }
            .btn-premium {
                @apply inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all active:scale-95;
            }
            .modern-table {
                @apply w-full text-left;
            }
            .modern-table th {
                @apply px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100;
            }
            .modern-table td {
                @apply px-6 py-5 border-b border-slate-50 text-sm align-middle;
            }
            .form-input-premium {
                @apply block w-full px-5 py-4 rounded-2xl border-slate-300 bg-white/50 backdrop-blur-sm text-slate-800 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 placeholder-slate-500 font-medium;
            }
            .form-label-premium {
                @apply block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-4;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50/50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 glass-sidebar text-white flex-shrink-0 hidden md:flex flex-col shadow-2xl">
            <div class="p-8">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/40 group-hover:rotate-12 transition-transform">
                        <i class="fas fa-h text-xl text-white"></i>
                    </div>
                    <span class="text-xl font-black tracking-tighter uppercase italic">
                        BH <span class="text-indigo-500">Hostel</span>
                    </span>
                </a>
            </div>
            
            <nav class="mt-4 flex-1 overflow-y-auto custom-scrollbar">
                <div class="px-8 mb-4">
                    <a href="{{ route('dashboard') }}" class="nav-link-premium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3 text-lg opacity-70"></i> Dashboard
                    </a>
                </div>
                
                <div class="px-9 py-4 uppercase text-[10px] font-black text-slate-400 tracking-[0.25em]">Academic Setup</div>
                <a href="{{ route('academic-years.index') }}" class="nav-link-premium {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt mr-4 opacity-70"></i> Academic Years
                </a>
                <a href="{{ route('batches.index') }}" class="nav-link-premium {{ request()->routeIs('batches.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group mr-4 opacity-70"></i> Batches
                </a>
                
                

                <div class="px-9 py-4 uppercase text-[10px] font-black text-slate-400 tracking-[0.25em]">Hostel Core</div>
                <a href="{{ route('categories.index') }}" class="nav-link-premium {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags mr-4 opacity-70"></i> Categories
                </a>
                <a href="{{ route('rooms.index') }}" class="nav-link-premium {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                    <i class="fas fa-door-open mr-4 opacity-70"></i> Rooms
                </a>
                <a href="{{ route('students.index') }}" class="nav-link-premium {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate mr-4 opacity-70"></i> Hostellers
                </a>
                
                <div class="px-9 py-4 uppercase text-[10px] font-black text-slate-400 tracking-[0.25em]">Operations</div>
                
                <a href="{{ route('leaves.index') }}" class="nav-link-premium {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text mr-4 opacity-70"></i> Leaves
                </a>
                <a href="{{ route('attendance.index') }}" class="nav-link-premium {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check mr-4 opacity-70"></i> Attendance
                </a>
                <a href="{{ route('remarks.index') }}" class="nav-link-premium {{ request()->routeIs('remarks.*') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots mr-4 opacity-70"></i> Remarks
                </a>
                
                <div class="px-9 py-4 uppercase text-[10px] font-black text-slate-400 tracking-[0.25em]">System</div>
                
                <a href="{{ route('users.index') }}" class="nav-link-premium {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog mr-4 opacity-70"></i> Users
                </a>

                <div class="px-8 mt-4 pt-4 border-t border-white/5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-slate-400 hover:text-rose-400 transition-colors w-full px-4 py-2 group">
                            <i class="fas fa-power-off mr-3 opacity-70 group-hover:rotate-90 transition-transform"></i> 
                            <span class="text-sm font-bold uppercase tracking-wider">Log Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50/30">
            <!-- Top Header -->
            <header class="bg-slate-900 border-b border-white/5 sticky top-0 z-30 py-5 px-10 flex justify-between items-center shadow-xl shadow-slate-900/10">
                <div class="flex items-center">
                    <button class="text-slate-400 md:hidden mr-6 hover:text-indigo-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">@yield('header')</h2>
                        <p class="text-[10px] text-indigo-400/80 font-bold uppercase tracking-widest mt-0.5">Hostel Management</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <form action="{{ route('search.index') }}" method="GET" class="hidden lg:flex items-center bg-white/5 border border-white/10 px-4 py-2 rounded-xl text-slate-400 hover:bg-white/10 transition-colors focus-within:bg-white/10 focus-within:border-indigo-500/50 group">
                        <i class="fas fa-search mr-3 text-xs opacity-50 group-focus-within:text-indigo-400 group-focus-within:opacity-100 transition-colors"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Global Search..." class="bg-transparent border-none outline-none text-xs font-bold opacity-70 group-hover:opacity-100 group-focus-within:opacity-100 text-white placeholder-slate-400 w-48 transition-all">
                    </form>

                    <div class="h-6 w-px bg-white/10"></div>

                    <button class="text-slate-400 hover:text-white relative transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-[9px] font-black rounded-full px-1.5 py-0.5 ring-4 ring-slate-900">3</span>
                    </button>
                    
                    <div class="flex items-center group cursor-pointer">
                        <div class="text-right mr-4 hidden md:block">
                            <div class="text-xs font-black text-white leading-none mb-1 capitalize">{{ Auth::user()->username }}</div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator</div>
                        </div>
                        <div class="h-11 w-11 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-black shadow-lg shadow-indigo-600/20 group-hover:scale-110 transition-transform border-4 border-slate-900">
                            {{ substr(Auth::user()->username, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8 max-w-9xl mx-auto">
                @if (session('success'))
                    <div class="mb-8 p-5 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-3xl shadow-sm flex items-center animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white mr-4 shadow-md">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="text-sm font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 p-5 bg-rose-50 border border-rose-100 text-rose-700 rounded-3xl shadow-sm flex items-center animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-8 h-8 bg-rose-600 rounded-lg flex items-center justify-center text-white mr-4 shadow-md">
                            <i class="fas fa-exclamation text-xs"></i>
                        </div>
                        <span class="text-sm font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
    @yield('scripts')
</body>
</html>
