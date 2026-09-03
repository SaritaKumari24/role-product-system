@extends('layouts.app')

@section('title', 'Register Account')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-700 items-center justify-center text-white text-2xl font-black shadow-xl shadow-brand-500/30 mb-3">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Create an Account</h2>
            <p class="text-xs text-slate-400 mt-1">Get started with role-based access control</p>
        </div>

        <!-- Registration Form Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-300 mb-1.5">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-xs"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition"
                               placeholder="Alex Morgan">
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition"
                               placeholder="alex@example.com">
                    </div>
                </div>

                <!-- Role Selector (for test evaluation) -->
                <div>
                    <label for="role" class="block text-xs font-semibold text-slate-300 mb-1.5">Account Role</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                        </span>
                        <select id="role" name="role"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm outline-none transition appearance-none">
                            <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer (Storefront Viewer)</option>
                            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager (Product & Category Management)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Full System Control)</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Select the role you'd like to assign for testing purposes.</p>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition"
                               placeholder="Minimum 8 characters">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-check-double text-xs"></i>
                        </span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition"
                               placeholder="Confirm your password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 py-3 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-sm shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span>Create Account</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                <p class="text-xs text-slate-400">
                    Already registered? 
                    <a href="{{ route('login') }}" class="font-bold text-brand-400 hover:text-brand-300 transition">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
