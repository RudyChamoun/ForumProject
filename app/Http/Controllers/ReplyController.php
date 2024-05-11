<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Post;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new Reply();
        $reply->content = $request->input('content');
        $reply->user_id = auth()->id();
        $reply->post_id = $post->id;
        $reply->save();

        return back();
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        return back();
    }

    public function edit(Reply $reply)
    {
        $this->authorize('update', $reply);
        return view('replies.edit', compact('reply'));
    }

    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);
        $request->validate([
            'content' => 'required|string',
        ]);
        $reply->update(['content' => $request->content]);
        return redirect()->back()->with('message', 'Reply updated successfully!');
    }
}

