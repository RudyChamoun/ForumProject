<?php

namespace App\Http\Controllers;

use App\Models\Post; // Importing the Post model
use Illuminate\Http\Request; // Importing the Request class
use Illuminate\Support\Facades\Auth; // Importing the Auth facade

class PostController extends Controller
{
    // Display a listing of posts with optional search and sorting
    public function index(Request $request)
    {
        $query = Post::with(['user', 'replies.user']); // Eager load relationships

        // Handling search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Handling sorting
        switch ($request->query('sort')) {
            case 'date':
                $query->orderBy('created_at', $request->query('direction', 'desc')); // Sort by creation date
                break;
            case 'user':
                $query->join('users', 'posts.user_id', '=', 'users.id')
                      ->orderBy('users.name', $request->query('direction', 'asc')); // Sort by user's name
                break;
            case 'popularity':
                $query->withCount('replies')
                      ->orderBy('replies_count', $request->query('direction', 'desc')); // Sort by number of replies
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default sorting by creation date
        }

        $posts = $query->paginate(10); // Paginate the results
        return view('posts.index', compact('posts')); // Return the view with the posts
    }

    // Show the form for creating a new post
    public function create()
    {
        return view('posts.create'); // Return the create view
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create a new post with the validated data
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->id(); // Set the authenticated user's ID
        $post->save(); // Save the post

        return redirect()->route('posts.index'); // Redirect to the posts index
    }

    // Show the form for editing the specified post
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // Authorize the user
        return view('posts.edit', compact('post')); // Return the edit view with the post
    }

    // Update the specified post in the database
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post); // Authorize the user
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update($request->all()); // Update the post with the validated data
        return redirect()->route('posts.index'); // Redirect to the posts index
    }

    // Remove the specified post from the database
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Authorize the user
        $post->delete(); // Delete the post
        return redirect()->route('posts.index'); // Redirect to the posts index
    }
}
