<?php
//importing all the Contorllers that are going to be invoked in the specified routes
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\LikeController;
//importing manually the middleware and applying it manually because of an issue with the Kernel.php setup
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');

// Login Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Redirect default route to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Posts Routes including search and sorting
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Replies Routes
Route::post('/posts/{post}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');
Route::get('/replies/{reply}/edit', [ReplyController::class, 'edit'])->name('replies.edit');
Route::put('/replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');

// Likes Routes
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'unlike'])->name('posts.unlike');

// Profile Routes
Route::get('profile', [AuthController::class, 'showProfile'])->name('profile.show');
Route::put('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [AuthController::class, 'changePassword'])->name('profile.password');


//Admin Routes

Route::group(['middleware' => ['auth', EnsureUserIsAdmin::class]], function () {
    Route::post('/admin/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');
    Route::post('/admin/posts/{post}/delete', [AdminController::class, 'deletePost'])->name('admin.posts.delete');
    Route::post('/admin/comments/{comment}/delete', [AdminController::class, 'deleteComment'])->name('admin.comments.delete');
});

