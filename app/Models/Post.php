<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importing the HasFactory trait
use Illuminate\Database\Eloquent\Model; // Importing the base Model class

class Post extends Model
{
    use HasFactory; // Using the HasFactory trait

    // Define the relationship between Post and User
    public function user() {
        return $this->belongsTo(User::class); // A Post belongs to a User
    }
    
    // Define the relationship between Post and Reply
    public function replies() {
        return $this->hasMany(Reply::class); // A Post has many Replies
    }
    
    // Define the relationship between Post and Like
    public function likes() {
        return $this->hasMany(Like::class); // A Post has many Likes
    }
    
    // Specify the attributes that are mass assignable
    protected $fillable = ['title', 'description', 'user_id'];
}
