<!-- resources/views/auth/register.blade.php -->

@extends('layouts.app') <!-- Extending the base layout 'app' -->

@section('content') <!-- Defining the content section -->
<div class="container">
    <h2>Register</h2>
    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data"> <!-- Form to submit registration data -->
        @csrf <!-- CSRF token for security -->
        <div class="form-group">
            <label for="name">Name:</label> <!-- Label for name input -->
            <input type="text" class="form-control" name="name" id="name" required> <!-- Name input field -->
        </div>
        <div class="form-group">
            <label for="email">Email:</label> <!-- Label for email input -->
            <input type="email" class="form-control" name="email" id="email" required> <!-- Email input field -->
        </div>
        <div class="form-group">
            <label for="password">Password:</label> <!-- Label for password input -->
            <input type="password" class="form-control" name="password" id="password" required> <!-- Password input field -->
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label> <!-- Label for password confirmation input -->
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required> <!-- Password confirmation input field -->
        </div>
        <div class="form-group">
            <label for="avatar">Avatar (optional):</label> <!-- Label for avatar input -->
            <input type="file" class="form-control" name="avatar" id="avatar"> <!-- Avatar input field -->
        </div>
        <button type="submit" class="btn btn-primary">Register</button> <!-- Submit button -->
    </form>
</div>
@endsection <!-- End of content section -->
