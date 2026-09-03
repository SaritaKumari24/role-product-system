@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-700 items-center justify-center text-white text-2xl font-black shadow-xl shadow-brand-500/30 mb-3">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Welcome Back</h2>
            <p class="text-xs text-slate-400 mt-1">Sign in to your account or pick a demo role</p>
        </div>

        <!-- Demo Account Quick Selector Pills -->
        <div class="mb-6 p-4 rounded-2xl bg-slate-900/80 border border-brand-500/20 shadow-lg">
            <p class="text-[11px] font-bold text-brand-300 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <i class="fa-solid fa-bolt text-amber-400"></i> Quick Demo Logins:
            </p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="fillCredentials('admin@example.com', 'password')" class="px-2.5 py-2 rounded-xl text-xs font-semibold bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 transition text-center group">
                    <i class="fa-solid fa-crown block mb-1 group-hover:scale-110 transition-transform"></i>
                    <span>Admin</span>
                </button>
                <button type="button" onclick="fillCredentials('manager@example.com', 'password')" class="px-2.5 py-2 rounded-xl text-xs font-semibold bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 transition text-center group">
                    <i class="fa-solid fa-user-tie block mb-1 group-hover:scale-110 transition-transform"></i>
                    <span>Manager</span>
                </button>
                <button type="button" onclick="fillCredentials('customer@example.com', 'password')" class="px-2.5 py-2 rounded-xl text-xs font-semibold bg-sky-500/10 hover:bg-sky-500/20 text-sky-300 border border-sky-500/30 transition text-center group">
                    <i class="fa-solid fa-user block mb-1 group-hover:scale-110 transition-transform"></i>
                    <span>Customer</span>
                </button>
            </div>
        </div>

        <!-- Login Form Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition"
                               placeholder="user@example.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-key text-xs"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 text-white text-sm placeholder-slate-500 outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-brand-600 focus:ring-brand-500/40">
                        <span class="text-xs text-slate-400">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 py-3 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-sm shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                <p class="text-xs text-slate-400">
                    Don't have an account yet? 
                    <a href="{{ route('register') }}" class="font-bold text-brand-400 hover:text-brand-300 transition">Create Account</a>
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
