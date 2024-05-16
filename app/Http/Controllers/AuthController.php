<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importing the Request class
use App\Models\User; // Importing the User model
use Illuminate\Support\Facades\Auth; // Importing the Auth facade
use Illuminate\Support\Facades\Hash; // Importing the Hash facade
use Illuminate\Support\Facades\Session; // Importing the Session facade
use Illuminate\Support\Facades\Cookie; // Importing the Cookie facade

class AuthController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register'); // Return the registration view
    }

    // Handle the registration request
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'nullable|image|max:1999'
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null // Store the avatar if provided
        ]);

        Auth::login($user); // Log the user in

        return redirect('/'); // Redirect to the homepage
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // Return the login view
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regenerate the session ID to prevent fixation
            return redirect()->intended('/posts'); // Redirect to the intended page
        }

        // Return back with an error message if authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    // Handle the logout request
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        // Invalidate the user's session
        $request->session()->invalidate();

        // Generate a new session token to avoid session fixation issues
        $request->session()->regenerateToken();

        // Redirect to the login page or homepage
        return redirect('/login'); // Redirect to login page or another appropriate location
    }

    // Show the user's profile
    public function showProfile()
    {
        return view('profile.show', ['user' => auth()->user()]); // Return the profile view with the authenticated user
    }

    // Update the user's profile
    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        // Update the authenticated user's profile
        auth()->user()->update($request->only('name', 'email'));

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.'); // Redirect back to profile with success message
    }

    // Change the user's password
    public function changePassword(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']); // Return back with an error if passwords do not match
        }

        // Update the user's password
        auth()->user()->update([
            'password' => Hash::make($request->new_password) // Hash the new password
        ]);

        return redirect()->route('profile.show')->with('success', 'Password changed successfully.'); // Redirect back to profile with success message
    }
}
