<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app') <!-- Extending the base layout 'app' -->

@section('content') <!-- Defining the content section -->
<div class="container">
    <h1>Login</h1>
    <form method="POST" action="{{ route('login.submit') }}"> <!-- Form to submit login data -->
        @csrf <!-- CSRF token for security -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label> <!-- Label for email input -->
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> <!-- Email input field -->
            @error('email') <!-- Display validation error for email -->
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label> <!-- Label for password input -->
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> <!-- Password input field -->
            @error('password') <!-- Display validation error for password -->
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Login</button> <!-- Submit button -->
    </form>
</div>
@endsection <!-- End of content section -->

