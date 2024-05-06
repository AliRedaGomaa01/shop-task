<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Admin;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{
        /**
     * Display the login view.
     */
    public function loginForm(): Response
    {
        return Inertia::render('AdminAuth/Login');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
            
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Login failed, return appropriate error message
    }

        /**
     * Display the registration view.
     */
    public function registerForm(): Response
    {
        return Inertia::render('AdminAuth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Admin::class,
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($admin));

        Auth::guard('admin')->login($admin);

        return redirect(route('dashboard', absolute: false));
    }

}
