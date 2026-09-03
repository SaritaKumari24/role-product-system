@extends('layouts.app')

@section('title', 'Sign In - KalaKriti')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-terracotta-500 to-amber-600 items-center justify-center text-white text-2xl font-black shadow-lg shadow-terracotta-500/30 mb-3">
                <i class="fa-solid fa-palette"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-[#2B231D] font-serif tracking-tight">Welcome Back</h2>
            <p class="text-xs text-[#675B50] mt-1">Sign in to your KalaKriti artisan or collector account</p>
        </div>

        <!-- Quick Demo Logins Pill -->
        <div class="mb-6 p-4 rounded-2xl bg-[#F8F4EC] border border-[#E0D4C0] shadow-sm">
            <p class="text-[11px] font-bold text-[#7C5731] uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <i class="fa-solid fa-bolt text-amber-600"></i> Quick Demo Logins:
            </p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="fillCredentials('admin@example.com', 'password')" class="px-2.5 py-2 rounded-xl text-xs font-bold bg-amber-500/10 hover:bg-amber-500/20 text-amber-800 border border-amber-500/30 transition text-center group">
                    <i class="fa-solid fa-crown block mb-1 group-hover:scale-110 transition-transform text-amber-600"></i>
                    <span>Admin</span>
                </button>
                <button type="button" onclick="fillCredentials('manager@example.com', 'password')" class="px-2.5 py-2 rounded-xl text-xs font-bold bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-800 border border-emerald-500/30 transition text-center group">
                    <i class="fa-solid fa-user-tie block mb-1 group-hover:scale-110 transition-transform text-emerald-600"></i>
                    <span>Manager</span>
                </button>
                <button type="button" onclick="fillCredentials('customer@example.com', 'password')" class="px-2.5 py-2 rounded-xl text-xs font-bold bg-terracotta-500/10 hover:bg-terracotta-500/20 text-terracotta-800 border border-terracotta-500/30 transition text-center group">
                    <i class="fa-solid fa-user block mb-1 group-hover:scale-110 transition-transform text-terracotta-600"></i>
                    <span>Customer</span>
                </button>
            </div>
        </div>

        <!-- Login Form Card -->
        <div class="artisan-card rounded-3xl p-6 sm:p-8 shadow-xl bg-white border border-[#EAE5D9]">
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none transition"
                               placeholder="user@example.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-key text-xs"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-[#FCFBF7] border-[#DCCFBA] text-terracotta-600 focus:ring-terracotta-500">
                        <span class="text-xs text-[#675B50]">Remember my login</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 py-3.5 rounded-xl bg-terracotta-500 hover:bg-terracotta-600 text-white font-bold text-xs sm:text-sm shadow-md shadow-terracotta-500/20 transition flex items-center justify-center gap-2">
                    <span>Sign In to Account</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-[#F2ECE0] text-center">
                <p class="text-xs text-[#675B50]">
                    Don't have an account yet? 
                    <a href="{{ route('register') }}" class="font-bold text-terracotta-600 hover:text-terracotta-700 transition">Create an Account</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endpush
@endsection
