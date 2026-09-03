@extends('layouts.app')

@section('title', 'Create Account - KalaKriti')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-terracotta-500 to-amber-600 items-center justify-center text-white text-2xl font-black shadow-lg shadow-terracotta-500/30 mb-3">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-[#2B231D] font-serif tracking-tight">Join KalaKriti</h2>
            <p class="text-xs text-[#675B50] mt-1">Register for an artisan, manager, or customer account</p>
        </div>

        <!-- Registration Form Card -->
        <div class="artisan-card rounded-3xl p-6 sm:p-8 shadow-xl bg-white border border-[#EAE5D9]">
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-xs"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none transition"
                               placeholder="e.g. Aarti Kumari">
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none transition"
                               placeholder="aarti@example.com">
                    </div>
                </div>

                <!-- Role Selector -->
                <div>
                    <label for="role" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Account Role</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                        </span>
                        <select id="role" name="role"
                                class="w-full pl-10 pr-8 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm outline-none transition appearance-none">
                            <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer (Storefront & Catalog Viewer)</option>
                            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager (Catalog & Category Management)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Full System & RBAC Control)</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none transition"
                               placeholder="Minimum 8 characters">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[#4A3B32] mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-check-double text-xs"></i>
                        </span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#FCFBF7] border border-[#DCCFBA] focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-500/20 text-slate-800 text-xs sm:text-sm placeholder-[#9C9184] outline-none transition"
                               placeholder="Re-enter password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 py-3.5 rounded-xl bg-terracotta-500 hover:bg-terracotta-600 text-white font-bold text-xs sm:text-sm shadow-md shadow-terracotta-500/20 transition flex items-center justify-center gap-2">
                    <span>Create My Account</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-[#F2ECE0] text-center">
                <p class="text-xs text-[#675B50]">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-terracotta-600 hover:text-terracotta-700 transition">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
