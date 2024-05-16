<?php
//To create Posts
?>

@extends('layouts.app') <!-- Extending the base layout 'app' -->

@section('content') <!-- Defining the content section -->
<div class="container">
    <h1>Create Post</h1>
    <form action="{{ route('posts.store') }}" method="POST"> <!-- Form to submit a new post -->
        @csrf <!-- CSRF token for security -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label> <!-- Label for title input -->
            <input type="text" class="form-control" id="title" name="title" required> <!-- Title input field -->
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label> <!-- Label for description input -->
            <textarea class="form-control" id="description" name="description" required></textarea> <!-- Description textarea field -->
        </div>
        <button type="submit" class="btn btn-primary">Submit</button> <!-- Submit button -->
    </form>
</div>
@endsection <!-- End of content section -->
