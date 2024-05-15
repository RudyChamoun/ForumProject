@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Posts</h1>
        <!-- Search, Sorting Form, and Logout Button -->
        <div class="d-flex align-items-center">
            <form action="{{ route('posts.index') }}" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search posts..." value="{{ request('search') }}">
                <select name="sort" class="form-control mr-2">
                    <option value="date">Sort by Date</option>
                    <option value="user">Sort by User</option>
                    <option value="popularity">Sort by Popularity</option>
                </select>
                <button type="submit" class="btn btn-primary mr-2">Apply</button>
            </form>
            <a href="{{ route('profile.show') }}" class="btn btn-info mr-2">View Profile</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
    <a href="{{ route('posts.create') }}" class="btn btn-primary" style="margin-bottom: 20px;">Create Post</a>
    @foreach ($posts as $post)
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">By {{ $post->user->name }} on {{ $post->created_at->toFormattedDateString() }}</h6>
                <p class="card-text">{{ $post->description }}</p>
                <div class="btn-group" role="group" aria-label="Post actions">
                    <span class="btn-group" role="group">
                        {{ $post->likes->count() }} Likes
                        @if ($post->likes->where('user_id', auth()->id())->count())
                            <form action="{{ route('posts.unlike', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary mx-1">Unlike</button>
                            </form>
                        @else
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success mx-1">Like</button>
                            </form>
                        @endif
                    </span>
                    @if (auth()->check() && (auth()->id() == $post->user_id || auth()->user()->isAdmin()))
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary mx-1">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-1">Delete</button>
                        </form>
                    @endif
                </div>
                <!-- Admin functionality: Deactivate User -->
                @if(auth()->check() && auth()->user()->isAdmin())
                    <form action="{{ route('admin.users.deactivate', $post->user->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to deactivate this user?');">Deactivate User</button>
                    </form>
                @endif
                <!-- Display replies -->
                <div class="replies mt-3">
                    <h6>Replies:</h6>
                    @foreach ($post->replies as $reply)
                        <div class="mt-2 border-bottom pb-2">
                            <strong>{{ $reply->user->name }}</strong> ({{ $reply->created_at->toFormattedDateString() }}):
                            <p>{{ $reply->content }}</p>
                            @if (auth()->id() === $reply->user_id)
                                <a href="{{ route('replies.edit', $reply) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('replies.destroy', $reply) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                    @auth
                        <form action="{{ route('replies.store', $post) }}" method="POST">
                            @csrf
                            <div class="form-group mt-2">
                                <textarea name="content" class="form-control" placeholder="Write a reply..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-secondary mt-2">Reply</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
    {{ $posts->links() }}
</div>
@endsection
