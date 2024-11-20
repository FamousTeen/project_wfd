<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the login form
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt login
        // if (Auth::guard('web')->attempt($credentials)) {
        //     // Authentication passed
        //     $request->session()->regenerate();

        //     // Redirect to the dashboard with user-specific data
        //     return redirect()->route('dashboard');
        // }

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        } else if (Auth::guard('account')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('account.dashboard');
        }

        // If authentication fails
        return redirect()->back()->with('error', 'Password atau email salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
