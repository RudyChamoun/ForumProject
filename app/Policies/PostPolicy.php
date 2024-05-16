<?php
//Policies file used to make sure only the owner of the post and the admin can update or delete the post
namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        // Allow update if the user is the post owner or an admin
        return $user->id === $post->user_id || $user->isAdmin();
    }

    public function delete(User $user, Post $post)
    {
        // Allow delete if the user is the post owner or an admin
        return $user->id === $post->user_id || $user->isAdmin();
    }
}

