<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $role = $request->input('role', 'customer');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        if ($user->hasRole(['admin', 'manager'])) {
            return redirect()->route('admin.dashboard')->with('success', 'Account created successfully! Welcome to your dashboard.');
        }

        return redirect()->route('shop.index')->with('success', 'Account registered successfully! Welcome to our store.');
    }
}

