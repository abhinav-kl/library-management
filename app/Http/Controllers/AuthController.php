<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * This constructor applies the AuthCheck middleware to all methods in this controller,
     * ensuring that only authenticated users can access the authentication features.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle the login request.
     *
     * Validates the incoming request, checks the user's credentials,
     * and redirects to the books index if successful.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'message' => "User not found",
            ]);
        }

        // here checking the logged in user and redirect to the the page of the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('books.index');
        }

        return back()->withErrors([
            'message' => "Invalid credentials",
        ]);
    }

    /**
     * Handle the logout request.
     *
     * Logs out the user, invalidates the session, and regenerates the CSRF token.
     * Redirects to the login page after logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
