<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $like = new Like(['user_id' => Auth::id()]);
        $post->likes()->save($like);

        return back();
    }

    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return back();
    }
}

