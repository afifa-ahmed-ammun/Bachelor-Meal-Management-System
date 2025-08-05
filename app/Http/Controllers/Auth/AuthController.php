<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
                'role' => 'required|in:admin,member'
            ]);

            // Check if user exists with the specified role
            $user = User::where('email', $request->email)
                       ->where('role', $request->role)
                       ->first();

            if (!$user) {
                return back()->with('error', 'No user found with this email and role combination.');
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Invalid password.');
            }

            // Store user details in session
            session([
                'user_id' => $user->id,
                'role' => $user->role,
                'user_name' => $user->first_name . ' ' . $user->last_name
            ]);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'Welcome back!');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'apartment' => 'required|string|max:255',
            'role' => 'required|in:admin,member',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = User::create([
                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'apartment' => $request->apartment,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('login')->with('success', 'User registered successfully! Please login.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Registration failed. Please try again.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('welcome')->with('success', 'You have been logged out successfully.');
    }
}
