@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <div class="container my-4">

        <div class="card post-show-card mx-auto shadow-sm">
            @if ($post->image)
                @if ($post->visibility === 'private' && Auth::id() === $post->user->id)
                    <span class="badge text-white position-absolute m-2"
                        style="z-index: 10; background-color: #396cb2; bottom: 27%; right: 0;">
                        Private
                    </span>
                @endif
                <div class="post-show-image-wrapper">
                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="post-show-image">
                </div>

                @if (Auth::user()->id == $post->user_id)
                    <div class="dropdown post-img-actions">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                            id="postActionDropdown{{ $post->id }}" data-bs-toggle="dropdown" aria-expanded="false"
                            style="border-radius: 50%; padding: 10px 10px;">
                            <i class="fa-solid fa-ellipsis fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="postActionDropdown{{ $post->id }}">
                            <li>
                                <a class="dropdown-item" href="{{ route('post.edit', $post->id) }}">
                                    <i class="fa-solid fa-pen me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('post.destroy', $post->id) }}" method="post" class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-solid fa-trash-can me-2"></i>Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            @endif

            <div class="card-body">
                <h2 class="post-show-title" style="line-height: 25px">{{ $post->title }}</h2>
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none post-show-author">by
                    {{ $post->user->name }}</a>
                <p class="post-show-body mt-3">{{ $post->body }}</p>

                {{-- @if (Auth::user()->id === $post->user_id)
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-edit">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('post.destroy', $post->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif --}}
            </div>
        </div>

        <div class="card comment-card mx-auto mt-4 shadow-sm p-3">
            <form action="{{ route('comment.store', $post->id) }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="comment" class="form-control" placeholder="Add a comment..."
                        value="{{ old('comment') }}">
                    <button type="submit" class="btn  text-white" style="background-color: #396cb2;">Post</button>
                </div>
                @error('comment')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </form>
        </div>

        @if ($post->comments->count())
            <div class="comments-list mt-3 mx-auto" style="max-width: 700px;">
                @foreach ($post->comments as $comment)
                    <div class="d-flex justify-content-between align-items-center comment-item shadow-sm rounded mb-2">
                        <div class="comment-text">
                            <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none fw-bold"
                                style="color: #27374D;">{{ $comment->user->name }}</a>
                            {{-- <span class="fw-bold">{{ $comment->user->name }}</span> --}}
                            <span class="text-muted small"> • {{ $comment->created_at->diffForHumans() }}</span>
                            <p class="mb-0">{{ $comment->body }}</p>
                        </div>
                        @if ($comment->user_id === Auth::user()->id)
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="ms-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete comment">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <!-- Styles -->
    <style>
        /* Post Card */
        .post-show-card {
            max-width: 700px;
            margin: 0 auto;
            border-radius: 16px;
            overflow: hidden;
            background-color: #f8fcff;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .post-show-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        .post-show-image-wrapper {
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
        }

        .post-show-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-show-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #27374D;
        }

        .post-show-author {
            font-size: 0.95rem;
            color: #526D82;
        }

        .post-show-body {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #27374D;
        }

        /* Buttons */
        .btn-edit {
            background-color: #526D82;
            color: #DDE6ED;
            border: none;
            font-size: 0.85rem;
        }

        .btn-edit:hover {
            background-color: #43596a;
        }

        .btn-delete {
            background-color: #F05454;
            color: #fff;
            border: none;
            font-size: 0.85rem;
        }

        .btn-delete:hover {
            background-color: #c94242;
        }

        /* Comment Form */
        .comment-card {
            max-width: 700px;
            background-color: #ffffff;
            border-radius: 12px;
        }

        /* Comments List */
        .comments-list .comment-item {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 12px 15px;
            /* balanced padding top/bottom */
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* vertical center delete button */
        }

        .comments-list .comment-text p {
            margin: 0;
        }

        .post-img-actions {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 10;
        }

        .post-img-actions .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            color: white;
            border: none;
        }

        .post-img-actions .btn:hover {
            /* background-color: rgba(0, 0, 0, 0.7); */
            color: #27374D
        }
    </style>
@endsection
