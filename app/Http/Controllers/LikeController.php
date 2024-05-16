<?php

namespace App\Http\Controllers;

use App\Models\Post; // Importing the Post model
use App\Models\Like; // Importing the Like model
use Illuminate\Http\Request; // Importing the Request class
use Illuminate\Support\Facades\Auth; // Importing the Auth facade

class LikeController extends Controller
{
    // Method to like a post
    public function like(Post $post)
    {
        $like = new Like(['user_id' => Auth::id()]); // Create a new like with the authenticated user's ID
        $post->likes()->save($like); // Save the like to the post's likes relationship

        return back(); // Redirect back to the previous page
    }

    // Method to unlike a post
    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete(); // Delete the like where the user ID matches the authenticated user's ID

        return back(); // Redirect back to the previous page
    }
}
