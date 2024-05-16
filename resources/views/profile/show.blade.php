@extends('layouts.app') <!-- Extending the base layout 'app' -->

@section('content') <!-- Defining the content section -->
<div class="container">
    <h1>Profile</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }} <!-- Display success message if exists -->
        </div>
    @endif
    <form action="{{ route('profile.update') }}" method="POST"> <!-- Form to update profile -->
        @csrf <!-- CSRF token for security -->
        @method('PUT') <!-- HTTP method spoofing to use PUT for updating the resource -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label> <!-- Label for name input -->
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required> <!-- Name input field with current value -->
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label> <!-- Label for email input -->
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required> <!-- Email input field with current value -->
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button> <!-- Submit button for updating profile -->
    </form>

    <h2>Change Password</h2>
    <form action="{{ route('profile.password') }}" method="POST"> <!-- Form to change password -->
        @csrf <!-- CSRF token for security -->
        @method('PUT') <!-- HTTP method spoofing to use PUT for updating the resource -->
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label> <!-- Label for current password input -->
            <input type="password" class="form-control" id="current_password" name="current_password" required> <!-- Current password input field -->
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label> <!-- Label for new password input -->
            <input type="password" class="form-control" id="new_password" name="new_password" required> <!-- New password input field -->
        </div>
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label> <!-- Label for new password confirmation input -->
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required> <!-- New password confirmation input field -->
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button> <!-- Submit button for changing password -->
    </form>
</div>
@endsection <!-- End of content section -->
