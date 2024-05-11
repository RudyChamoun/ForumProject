<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
class AuthController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle the registration request
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'nullable|image|max:1999'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function showLoginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->intended('/posts');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.'
    ]);
}

public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the user's session.
        $request->session()->invalidate();

        // Generate a new session token to avoid session fixation issues after logout.
        $request->session()->regenerateToken();

        
        // Redirect to homepage or login page
        return redirect('/login');  // Redirect to login page or wherever you think is appropriate
    }

    public function showProfile()
{
    return view('profile.show', ['user' => auth()->user()]);
}

public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
    ]);

    auth()->user()->update($request->only('name', 'email'));

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    if (!Hash::check($request->current_password, auth()->user()->password)) {
        return back()->withErrors(['current_password' => 'Current password does not match']);
    }

    auth()->user()->update([
        'password' => Hash::make($request->new_password)
    ]);

    return redirect()->route('profile.show')->with('success', 'Password changed successfully.');
}

}



