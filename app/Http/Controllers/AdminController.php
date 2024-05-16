<?php

namespace App\Http\Controllers;

use App\Models\User; // Importing the User model
use App\Models\Post; // Importing the Post model
use Illuminate\Http\Request; // Importing the Request class

class AdminController extends Controller
{
    // Method to deactivate a user
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id); // Find the user by ID, or fail if not found
        $user->is_active = false; // Set the user's 'is_active' attribute to false
        $user->save(); // Save the changes to the database

        return back()->with('success', 'User has been deactivated.'); // Redirect back with a success message
    }

    // Method to delete a post
    public function deletePost($id)
    {
        $post = Post::findOrFail($id); // Find the post by ID, or fail if not found
        $post->delete(); // Delete the post

        return back()->with('success', 'Post has been deleted.'); // Redirect back with a success message
    }

    // Method to delete a comment
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id); // Find the comment by ID, or fail if not found
        $comment->delete(); // Delete the comment

        return back()->with('success', 'Comment has been deleted.'); // Redirect back with a success message
    }
}
