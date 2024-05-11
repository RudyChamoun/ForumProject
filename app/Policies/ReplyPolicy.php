<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reply $reply)
    {
        // Allow update if the user is the reply owner
        return $user->id === $reply->user_id;
    }

    public function delete(User $user, Reply $reply)
    {
        // Allow delete if the user is the reply owner or an admin
        return $user->id === $reply->user_id || $user->isAdmin();
    }
}
