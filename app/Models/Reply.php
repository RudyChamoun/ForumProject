<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importing the HasFactory trait
use Illuminate\Database\Eloquent\Model; // Importing the base Model class

class Reply extends Model
{
    use HasFactory; // Using the HasFactory trait

    // Define the relationship between Reply and User
    public function user() {
        return $this->belongsTo(User::class); // A Reply belongs to a User
    }
    
    // Define the relationship between Reply and Post
    public function post() {
        return $this->belongsTo(Post::class); // A Reply belongs to a Post
    }
}
