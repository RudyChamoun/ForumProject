<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importing the HasFactory trait
use Illuminate\Foundation\Auth\User as Authenticatable; // Importing the base Authenticatable class
use Illuminate\Notifications\Notifiable; // Importing the Notifiable trait

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Using the HasFactory and Notifiable traits

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Define the relationship between User and Post
    public function posts() {
        return $this->hasMany(Post::class); // A User has many Posts
    }
    
    // Define the relationship between User and Reply
    public function replies() {
        return $this->hasMany(Reply::class); // A User has many Replies
    }

    // Define the relationship between User and Like
    public function likes() {
        return $this->hasMany(Like::class); // A User has many Likes
    }

    // Method to check if the user is an admin
    public function isAdmin()
    {
        return $this->is_admin; // Return if the user is an admin
    }
}
