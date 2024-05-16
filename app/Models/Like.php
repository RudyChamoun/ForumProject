<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Importing the base Model class

class Like extends Model
{
    // Specify the attributes that are mass assignable
    protected $fillable = ['post_id', 'user_id'];

    // Define the relationship between Like and Post
    public function post()
    {
        return $this->belongsTo(Post::class); // A Like belongs to a Post
    }

    // Define the relationship between Like and User
    public function user()
    {
        return $this->belongsTo(User::class); // A Like belongs to a User
    }
}
