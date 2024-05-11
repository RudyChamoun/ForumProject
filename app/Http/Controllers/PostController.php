<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
{
    $query = Post::with(['user', 'replies.user']);

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
            $query->orderBy('created_at', $request->query('direction', 'desc'));
            break;
        case 'user':
            $query->join('users', 'posts.user_id', '=', 'users.id')
                  ->orderBy('users.name', $request->query('direction', 'asc'));
            break;
        case 'popularity':
            $query->withCount('replies')
                  ->orderBy('replies_count', $request->query('direction', 'desc'));
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }

    $posts = $query->paginate(10);
    return view('posts.index', compact('posts'));
}


    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update($request->all());
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}

