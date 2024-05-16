@extends('layouts.app') <!-- Extending the base layout 'app' -->

<?php
// To edit posts, we need to update the edit.blade.php file in the posts directory.
?>

@section('content') <!-- Defining the content section -->
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST"> <!-- Form to update an existing post -->
        @csrf <!-- CSRF token for security -->
        @method('PUT') <!-- HTTP method spoofing to use PUT for updating the resource -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label> <!-- Label for title input -->
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required> <!-- Title input field with current value -->
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label> <!-- Label for description input -->
            <textarea class="form-control" id="description" name="description" required>{{ $post->description }}</textarea> <!-- Description textarea field with current value -->
        </div>
        <button type="submit" class="btn btn-primary">Update</button> <!-- Submit button -->
    </form>
</div>
@endsection <!-- End of content section -->
