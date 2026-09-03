<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - Product Management System</title>

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

    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .admin-sidebar {
            background: linear-gradient(180deg, #090d16 0%, #0c1220 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }
        .admin-header {
            background: rgba(10, 15, 29, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .admin-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex bg-slate-950 text-slate-100 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Sidebar Navigation -->
    <aside class="w-64 fixed inset-y-0 left-0 z-40 admin-sidebar flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Sidebar Header / Logo -->
            <div class="h-16 flex items-center gap-3 px-6 border-b border-white/10">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-indigo-700 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-brand-500/30">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight bg-gradient-to-r from-white via-slate-100 to-slate-400 bg-clip-text text-transparent">
                        Apex<span class="text-brand-400">Control</span>
                    </span>
                    <span class="block text-[9px] font-bold tracking-widest text-brand-400 uppercase -mt-0.5">
                        {{ auth()->user()->hasRole('admin') ? 'Admin Panel' : 'Manager Panel' }}
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="px-4 py-6 space-y-1.5">
                <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Core Dashboard
                </div>

                <!-- Dashboard link -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-gauge-high text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-brand-400' }}"></i>
                    <span>Dashboard Overview</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Catalog Management
                </div>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.products.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-boxes-stacked text-sm {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-brand-400' }}"></i>
                    <span>Products</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.categories.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-folder-tree text-sm {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-brand-400' }}"></i>
                    <span>Categories</span>
                </a>

                <!-- Admin Only Section -->
                @role('admin')
                    <div class="pt-5 px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Administration (Admin Only)
                    </div>

                    <!-- User & Role Management -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <i class="fa-solid fa-users text-sm {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-amber-400' }}"></i>
                        <span>User Accounts</span>
                    </a>

                    <!-- Dynamic Role Management -->
                    <a href="{{ route('admin.roles.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.roles.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <i class="fa-solid fa-shield-halved text-sm {{ request()->routeIs('admin.roles.*') ? 'text-white' : 'text-brand-400' }}"></i>
                        <span>Dynamic Roles</span>
                    </a>

                    <!-- Dynamic Permission Matrix -->
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.permissions.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <i class="fa-solid fa-key text-sm {{ request()->routeIs('admin.permissions.*') ? 'text-white' : 'text-amber-400' }}"></i>
                        <span>Permissions Matrix</span>
                    </a>
                @endrole
            </div>
        </div>

        <!-- Sidebar Footer / Storefront Link -->
        <div class="p-4 border-t border-white/10 space-y-2">
            <a href="{{ route('shop.index') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-slate-300 hover:text-white bg-slate-900/60 hover:bg-slate-800/80 border border-white/5 transition">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-arrow-up-right-from-square text-brand-400"></i>
                    <span>View Customer Store</span>
                </span>
                <span class="text-[10px] text-slate-400">Live</span>
            </a>

            <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-900/40 border border-white/5">
                <div class="w-8 h-8 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-200">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-medium text-brand-400 uppercase">{{ auth()->user()->roles->first()?->name }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="md:pl-64 flex flex-col flex-1 min-h-screen">
        <!-- Admin Topbar -->
        <header class="admin-header sticky top-0 z-30 h-16 px-4 sm:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                    @yield('header_title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <!-- User role badge -->
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ auth()->user()->hasRole('admin') ? 'bg-amber-500/10 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/30' }}">
                    <i class="fa-solid {{ auth()->user()->hasRole('admin') ? 'fa-crown text-amber-400' : 'fa-user-shield text-emerald-400' }}"></i>
                    {{ ucfirst(auth()->user()->roles->first()?->name ?? 'User') }} Access
                </span>

                <a href="{{ route('shop.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-300 hover:text-white bg-slate-900 border border-slate-700 transition">
                    <i class="fa-solid fa-store mr-1.5 text-brand-400"></i> Storefront
                </a>
            </div>
        </header>

        <!-- Flash Alerts -->
        <div class="px-4 sm:px-8 pt-4">
            @if(session('success'))
                <div class="mb-4 p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-400 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-200"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 shadow-lg">
                    <div class="flex items-center gap-3 mb-1">
                        <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg"></i>
                        <span class="text-sm font-semibold">Validation Errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-300 ml-6">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-8">
            @yield('content')
        </main>
    </div>

    <!-- Cropper.js JavaScript CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    @stack('scripts')
</body>
</html>
