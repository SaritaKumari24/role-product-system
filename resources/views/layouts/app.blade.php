<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#FCFBF7] text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Handcraft & Art Marketplace') - KalaKriti</title>
    <meta name="description" content="Discover authentic handcrafted products, home décor, personalized gifts, festive collections, and unique artisan creations from Katihar, Bihar.">

    <!-- Google Fonts: Plus Jakarta Sans + Playfair Display for Artisanal Elegance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        artisan: {
                            50: '#fdfbf7',
                            100: '#f7f2e7',
                            200: '#eee3cb',
                            300: '#e0cca3',
                            400: '#ceae75',
                            500: '#b8904f',
                            600: '#9d733d',
                            700: '#7c5731',
                            800: '#67472c',
                            900: '#563c27',
                        },
                        terracotta: {
                            50: '#fdf6f2',
                            100: '#faeae3',
                            200: '#f4d6c7',
                            300: '#ebb8a2',
                            400: '#de9072',
                            500: '#c85a32',
                            600: '#b74724',
                            700: '#99371d',
                            800: '#7d2e1b',
                            900: '#672a1b',
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
            background-color: #FCFBF7;
            color: #2D3748;
        }
        .artisan-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #EAE5D9;
        }
        .artisan-card {
            background: #FFFFFF;
            border: 1px solid #EAE5D9;
            box-shadow: 0 4px 20px -4px rgba(45, 33, 20, 0.05);
        }
        .artisan-card:hover {
            box-shadow: 0 12px 30px -6px rgba(200, 90, 50, 0.12);
            border-color: #DCCFBA;
        }
        .artisan-badge {
            background: #F8F4EC;
            color: #99371D;
            border: 1px solid #E6D7C3;
        }
    </style>
</head>
<body class="min-h-full flex flex-col antialiased selection:bg-terracotta-500 selection:text-white">

    <!-- Top Announcement Bar (matching LittlePicassos) -->
    <div class="bg-[#2B231D] text-[#E7DFD5] text-xs py-2 px-4 border-b border-[#3D332B]">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <i class="fa-solid fa-sparkles mr-1"></i> Authentic Artisan Crafts
                </span>
                <span class="hidden sm:inline">Handcrafted with love from Katihar, Bihar &bull; Worldwide Delivery</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] text-[#C9BFB5]">
                <a href="https://api.whatsapp.com/send/?phone=919570479650&text=Hello+KalaKriti" target="_blank" class="hover:text-white transition flex items-center gap-1">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i> +91 919191991
                </a>
                <span class="hidden md:inline text-slate-600">|</span>
                <a href="mailto:info@kalakriti.in" class="hidden md:flex items-center gap-1 hover:text-white transition">
                    <i class="fa-regular fa-envelope text-amber-300"></i> info@kalakriti.in
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="artisan-header sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-4">
                <!-- Brand Logo (KalaKriti) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-terracotta-500 to-amber-600 flex items-center justify-center text-white font-black text-xl shadow-md shadow-terracotta-500/30 group-hover:scale-105 transition duration-200">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black tracking-tight text-[#2B231D] font-serif">
                            Kala<span class="text-terracotta-500">Kriti</span>
                        </span>
                        <span class="block text-[10px] font-bold tracking-widest text-[#7C5731] uppercase -mt-1">
                            Handcraft & Art Marketplace
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-6 text-sm font-semibold text-[#4A3B32]">
                    <a href="{{ route('home') }}" class="hover:text-terracotta-500 transition py-1 {{ request()->routeIs('home') && !request('category') ? 'text-terracotta-600 border-b-2 border-terracotta-500' : '' }}">
                        Home
                    </a>

                    <!-- Category Dropdown -->
                    <div class="relative group">
                        <a href="{{ route('shop.index') }}" class="flex items-center gap-1 hover:text-terracotta-500 transition py-1">
                            <span>Shop Categories</span>
                            <i class="fa-solid fa-chevron-down text-[10px] group-hover:rotate-180 transition duration-200"></i>
                        </a>
                        <div class="absolute left-0 top-full pt-2 hidden group-hover:block w-64 z-50">
                            <div class="bg-white rounded-2xl p-3 shadow-xl border border-[#EAE5D9] space-y-1">
                                <a href="{{ route('shop.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-[#F8F4EC] hover:text-terracotta-600 transition">
                                    All Collections
                                </a>
                                <a href="{{ route('shop.index', ['category' => 'madhubani-paintings']) }}" class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-[#F8F4EC] hover:text-terracotta-600 transition">
                                    🎨 Madhubani Paintings
                                </a>
                                <a href="{{ route('shop.index', ['category' => 'terracotta-clay-dolls']) }}" class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-[#F8F4EC] hover:text-terracotta-600 transition">
                                    🏺 Terracotta & Clay Dolls
                                </a>
                                <a href="{{ route('shop.index', ['category' => 'jute-sikki-grass-crafts']) }}" class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-[#F8F4EC] hover:text-terracotta-600 transition">
                                    🌾 Jute & Sikki Grass Crafts
                                </a>
                                <a href="{{ route('shop.index', ['category' => 'sujini-embroidery-textiles']) }}" class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-[#F8F4EC] hover:text-terracotta-600 transition">
                                    🧵 Sujini Embroidery Textiles
                                </a>
                                <a href="{{ route('shop.index', ['category' => 'wooden-bamboo-toys']) }}" class="block px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-[#F8F4EC] hover:text-terracotta-600 transition">
                                    🪵 Wooden & Bamboo Toys
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('shop.index') }}" class="hover:text-terracotta-500 transition py-1 {{ request()->routeIs('shop.index') && request('category') ? 'text-terracotta-600 font-bold' : '' }}">
                        Explore All Art
                    </a>
                </nav>

                <!-- Search & Auth Section -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->hasRole(['admin', 'manager']) || auth()->user()->can('view-admin-panel'))
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#2B231D] hover:bg-[#3D332B] text-amber-200 shadow-sm transition">
                                <i class="fa-solid fa-gauge-high text-amber-400"></i>
                                <span class="hidden sm:inline">Admin Dashboard</span>
                            </a>
                        @endif

                        <!-- User Profile Info -->
                        <div class="flex items-center gap-2.5 pl-2">
                            <div class="w-9 h-9 rounded-full bg-terracotta-100 border border-terracotta-300 flex items-center justify-center text-xs font-bold text-terracotta-800">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs font-bold text-[#2B231D] truncate max-w-[100px]">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] font-semibold text-terracotta-600 capitalize">{{ auth()->user()->roles->first()?->name ?? 'Customer' }}</span>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" title="Sign Out" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-[#4A3B32] hover:text-terracotta-600 transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-terracotta-500 hover:bg-terracotta-600 text-white shadow-md shadow-terracotta-500/20 transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    @if(session('success') || session('error') || session('info') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- E-Commerce Footer (matching LittlePicassos) -->
    <footer class="mt-24 bg-[#211A15] text-[#D8CFC5] border-t border-[#362C24]">
        <!-- Value Badges Row -->
        <div class="border-b border-[#362C24] py-10 bg-[#28201B]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-terracotta-500/20 border border-terracotta-500/30 flex items-center justify-center text-terracotta-400 text-xl flex-shrink-0">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Fast Worldwide Delivery</h4>
                            <p class="text-xs text-[#A89D91] mt-0.5">Reliable doorstep courier service across India & abroad.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xl flex-shrink-0">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">100% Genuine Quality</h4>
                            <p class="text-xs text-[#A89D91] mt-0.5">Authentic handcrafted masterworks from local artisans.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl flex-shrink-0">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Secure Checkout</h4>
                            <p class="text-xs text-[#A89D91] mt-0.5">Safe and protected payment with zero hassle.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center text-sky-400 text-xl flex-shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Artisan Support</h4>
                            <p class="text-xs text-[#A89D91] mt-0.5">Direct WhatsApp guidance from our Katihar hub.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Main Links -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                <!-- Brand & Bio -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-terracotta-500 to-amber-600 flex items-center justify-center text-white font-black text-lg">
                            <i class="fa-solid fa-palette"></i>
                        </div>
                        <span class="text-2xl font-black text-white font-serif">Kala<span class="text-terracotta-400">Kriti</span></span>
                    </div>
                    <p class="text-xs leading-relaxed text-[#A89D91] max-w-sm">
                        KalaKriti is a dedicated handcraft & art marketplace bridging master heritage artisans from Katihar and Mithila directly with art lovers worldwide.
                    </p>
                    <div class="pt-2 flex items-center gap-3 text-sm">
                        <a href="https://www.instagram.com" target="_blank" class="w-9 h-9 rounded-xl bg-[#2E241E] hover:bg-terracotta-600 text-white flex items-center justify-center transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send/?phone=919570479650" target="_blank" class="w-9 h-9 rounded-xl bg-[#2E241E] hover:bg-emerald-600 text-white flex items-center justify-center transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="mailto:info@kalakriti.in" class="w-9 h-9 rounded-xl bg-[#2E241E] hover:bg-amber-600 text-white flex items-center justify-center transition">
                            <i class="fa-regular fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Popular Categories -->
                <div class="space-y-3 text-xs">
                    <h5 class="font-bold text-white uppercase tracking-wider text-xs font-serif">Categories</h5>
                    <ul class="space-y-2 text-[#A89D91]">
                        <li><a href="{{ route('shop.index', ['category' => 'madhubani-paintings']) }}" class="hover:text-terracotta-400 transition">Madhubani Paintings</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'terracotta-clay-dolls']) }}" class="hover:text-terracotta-400 transition">Terracotta & Clay Dolls</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'jute-sikki-grass-crafts']) }}" class="hover:text-terracotta-400 transition">Jute & Sikki Grass</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'sujini-embroidery-textiles']) }}" class="hover:text-terracotta-400 transition">Sujini Textiles</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'wooden-bamboo-toys']) }}" class="hover:text-terracotta-400 transition">Wooden Toys</a></li>
                    </ul>
                </div>

                <!-- Quick Navigation -->
                <div class="space-y-3 text-xs">
                    <h5 class="font-bold text-white uppercase tracking-wider text-xs font-serif">About</h5>
                    <ul class="space-y-2 text-[#A89D91]">
                        <li><a href="{{ route('home') }}" class="hover:text-terracotta-400 transition">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-terracotta-400 transition">All Products</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-terracotta-400 transition">About Us</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-terracotta-400 transition">Our Artisan Team</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-terracotta-400 transition">Contact & Support</a></li>
                    </ul>
                </div>

                <!-- Contact & Location -->
                <div class="space-y-3 text-xs">
                    <h5 class="font-bold text-white uppercase tracking-wider text-xs font-serif">Artisan Hub</h5>
                    <p class="text-[#A89D91] leading-relaxed">
                        <i class="fa-solid fa-location-dot text-terracotta-400 mr-1.5"></i>
                        Katihar, Bihar, India &bull; 854105
                    </p>
                    <p class="text-[#A89D91]">
                        <i class="fa-brands fa-whatsapp text-emerald-400 mr-1.5"></i>
                        +91 95704 79650
                    </p>
                    <p class="text-[#A89D91]">
                        <i class="fa-regular fa-envelope text-amber-400 mr-1.5"></i>
                        info@kalakriti.in
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright Bottom -->
        <div class="border-t border-[#362C24] py-6 text-center text-xs text-[#8A7F73]">
            <p>Copyright KalaKriti &copy; {{ date('Y') }}. All Rights Reserved &bull; Authentic Handcraft & Art Marketplace in Katihar, Bihar</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
