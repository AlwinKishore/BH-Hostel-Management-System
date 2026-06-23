<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hapi Hostel') }} - Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Tailwind CSS CDN Fallback -->
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
                .glass-dark {
                    @apply bg-slate-900/65 backdrop-blur-xl border border-white/10;
                }
                .form-input-premium {
                    @apply w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200;
                }
                .form-label-premium {
                    @apply block text-sm font-semibold text-slate-300 mb-1.5 ml-1;
                }
                .btn-primary {
                    @apply inline-flex items-center justify-center px-6 py-3 font-bold rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98];
                }
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-950">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-4 bg-mesh selection:bg-indigo-500 selection:text-white">
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-600 rounded-3xl shadow-2xl shadow-indigo-500/20 mb-4 transform -rotate-6 transition-transform hover:rotate-0 duration-300">
                    <i class="fas fa-h text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-black tracking-tight text-white uppercase italic">
                    Hapi <span class="text-indigo-500">Hostel</span>
                </h1>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-2">Management System</p>
            </div>

            <div class="w-full sm:max-w-md glass-dark rounded-[2.5rem] shadow-2xl overflow-hidden p-8 sm:p-10 border border-white/10">
                {{ $slot }}
            </div>
            
            <div class="mt-12 flex flex-col items-center space-y-4">
                <div class="flex space-x-6 text-slate-500 text-sm font-medium">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Help Center</a>
                </div>
                <div class="text-slate-600 text-[10px] font-bold uppercase tracking-widest">
                    &copy; {{ date('Y') }} Hapi Town.
                </div>
            </div>
        </div>
    </body>
</html>
