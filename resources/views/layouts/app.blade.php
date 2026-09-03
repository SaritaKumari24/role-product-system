<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ApexStore') - Premium Product Showcase</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                            950: '#1e1b4b',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-nav {
            background: rgba(10, 15, 29, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glow-effect {
            box-shadow: 0 0 40px -10px rgba(99, 102, 241, 0.35);
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-slate-950 text-slate-100 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Top Announcement / Info Bar -->
    <div class="bg-gradient-to-r from-brand-900 via-indigo-950 to-slate-900 border-b border-indigo-500/20 py-1.5 px-4 text-xs font-medium text-indigo-200">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-500/20 text-brand-300 border border-brand-500/30">
                    <i class="fa-solid fa-shield-halved mr-1"></i> RBAC Enabled
                </span>
                <span>Role-Based Product Management System (Laravel + Spatie)</span>
            </div>
            <div class="hidden md:flex items-center gap-4 text-slate-400">
                <span><i class="fa-solid fa-code mr-1"></i> Laravel 11 MVC</span>
                <span><i class="fa-solid fa-crop-simple mr-1"></i> Cropper.js Image Engine</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="glass-nav sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-indigo-700 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-brand-500/30 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-white via-slate-100 to-slate-400 bg-clip-text text-transparent">
                                Apex<span class="text-brand-400">Store</span>
                            </span>
                            <span class="block text-[10px] font-semibold tracking-wider text-slate-400 uppercase -mt-1">RBAC System</span>
                        </div>
                    </a>

                    <!-- Nav Links -->
                    <div class="hidden md:flex items-center gap-1 ml-8">
                        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('home') || request()->routeIs('shop.index') ? 'text-white bg-white/10 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <i class="fa-solid fa-store mr-1.5 text-brand-400"></i> Storefront
                        </a>
                    </div>
                </div>

                <!-- Right Actions / Auth Area -->
                <div class="flex items-center gap-3">
                    @auth
                        <!-- If Admin / Manager, show Dashboard link -->
                        @if(auth()->user()->hasRole(['admin', 'manager']))
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-brand-600 hover:bg-brand-500 text-white shadow-md shadow-brand-600/30 transition transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span>Manage Dashboard</span>
                                <span class="px-1.5 py-0.5 rounded text-[10px] bg-black/20 uppercase font-bold tracking-wider">
                                    {{ auth()->user()->roles->first()?->name }}
                                </span>
                            </a>
                        @endif

                        <!-- User Profile Pill -->
                        <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                            <div class="flex flex-col text-right">
                                <span class="text-xs font-semibold text-white">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] font-medium text-brand-400 flex items-center justify-end gap-1">
                                    <i class="fa-solid fa-circle text-[6px] text-emerald-400"></i>
                                    {{ ucfirst(auth()->user()->roles->first()?->name ?? 'User') }}
                                </span>
                            </div>

                            <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-200">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" title="Logout" class="p-2 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Guest Auth Links -->
                        <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/5 transition">
                            <i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white shadow-md shadow-brand-600/30 transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-user-plus mr-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Alerts -->
    @if(session('success') || session('error') || session('info') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-400 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-200"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 rounded-xl bg-sky-950/80 border border-sky-500/40 text-sky-200 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-info text-sky-400 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('info') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-sky-400 hover:text-sky-200"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 shadow-lg">
                    <div class="flex items-center gap-3 mb-1">
                        <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg"></i>
                        <span class="text-sm font-semibold">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-300 ml-6">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-slate-800/80 bg-slate-950/90 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold text-sm">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <span class="font-bold text-white text-base">Apex<span class="text-brand-400">Store</span></span>
                        <p class="text-xs text-slate-400">Laravel 11 Role-Based Product Management System</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-6 text-xs text-slate-400">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-brand-400"></i> Spatie RBAC</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-crop text-emerald-400"></i> Cropper.js</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-database text-sky-400"></i> Eloquent ORM</span>
                </div>

                <div class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} Built for Laravel Test Evaluation.
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
