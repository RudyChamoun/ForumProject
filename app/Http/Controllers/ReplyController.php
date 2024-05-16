<?php

namespace App\Http\Controllers;

use App\Models\Reply; // Importing the Reply model
use App\Models\Post; // Importing the Post model
use Illuminate\Http\Request; // Importing the Request class

class ReplyController extends Controller
{
    // Store a newly created reply in the database
    public function store(Request $request, Post $post)
    {
        // Validate the incoming request data
        $request->validate([
            'content' => 'required|string',
        ]);

        // Create a new reply with the validated data
        $reply = new Reply();
        $reply->content = $request->input('content'); // Set the content of the reply
        $reply->user_id = auth()->id(); // Set the authenticated user's ID
        $reply->post_id = $post->id; // Set the post ID
        $reply->save(); // Save the reply

        return back(); // Redirect back to the previous page
    }

    // Remove the specified reply from the database
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply); // Authorize the user
        $reply->delete(); // Delete the reply
        return back(); // Redirect back to the previous page
    }

    // Show the form for editing the specified reply
    public function edit(Reply $reply)
    {
        $this->authorize('update', $reply); // Authorize the user
        return view('replies.edit', compact('reply')); // Return the edit view with the reply
    }

    // Update the specified reply in the database
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply); // Authorize the user
        // Validate the incoming request data
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply->update(['content' => $request->content]); // Update the reply with the validated data
        return redirect()->back()->with('message', 'Reply updated successfully!'); // Redirect back with a success message
    }
}
