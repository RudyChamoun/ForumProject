<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deactivateUser($id)
{
    $user = User::findOrFail($id);
    $user->is_active = false;
    $user->save();

    return back()->with('success', 'User has been deactivated.');
}

public function deletePost($id)
{
    $post = Post::findOrFail($id);
    $post->delete();

    return back()->with('success', 'Post has been deleted.');
}

public function deleteComment($id)
{
    $comment = Comment::findOrFail($id);
    $comment->delete();

    return back()->with('success', 'Comment has been deleted.');
}

}
