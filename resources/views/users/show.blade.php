@extends('layouts.app')

@section('title')

@section('content')
    @if (Auth::id() === $user->id)
        <button type="button" class="fab-btn" data-bs-toggle="modal" data-bs-target="#createPostModal">
            <i class="fa-solid fa-plus fa-lg"></i>
        </button>

        @include('posts.create')
    @endif
    <div class="container my-3">

        <div class="card user-profile-card mb-4 shadow-sm p-4 d-flex flex-row align-items-start">
            <div class="left-column me-4 text-center" style="flex-shrink: 0; min-width: 250px;">
                <!-- Avatar -->
                <div class="user-avatar mb-3">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}"
                            class="rounded-circle"
                            style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #396cb2;">
                    @else
                        <div class="avatar-placeholder rounded-circle d-flex justify-content-center align-items-center ms-5"
                            style="width: 150px; height: 150px; background-color: #e8e9eb; border: 3px solid #396cb2; overflow: hidden;">
                            <i class="fa-solid fa-user text-muted" style="font-size: 60px;"></i>
                        </div>
                    @endif
                </div>

                <h2 class="fw-bold mb-3" style="color: #27374D;">{{ $user->name }}</h2>

                @if (Auth::id() === $user->id)
                    <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-sm btn-custom">Edit Profile</a>
                @endif
            </div>

            <div class="right-column flex-fill d-flex justify-content-center align-items-center">
                @if ($user->about)
                    <div class="about-me my-5 w-50 p-4 shadow-sm text-center"
                        style="background: #e8e9eb; border-radius: 16px; font-size: 1.05rem; line-height: 1.8; color: #495057;">

                        <h5 class="fw-semibold mb-4" style="color:#396cb2;">
                            <i class="fa-solid fa-user me-2"></i> A Little About Me
                        </h5>

                        @php
                            $aboutLines = array_values(array_filter(array_map('trim', explode("\n", $user->about))));
                        @endphp

                        <ul class="list-unstyled mb-0" style="padding-left: 0;">
                            @foreach ($aboutLines as $line)
                                <li class="mb-2">{{ $line }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="about-me my-5 w-50 p-4 shadow-sm text-center"
                        style="background: #e8e9eb; border-radius: 16px; font-size: 1.05rem; line-height: 1.8; color: #495057;">
                        @if (Auth::id() === $user->id)
                            <h5 class="fw-semibold mb-4 text-muted">You haven't added your bio yet.</h5>
                            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-sm btn-custom">Add Your Bio</a>
                        @else
                            <h5 class="fw-semibold text-muted">{{ ucfirst($user->name) }} hasn't added a bio yet.</h5>
                            <p class="text-muted">Check back later to learn more about {{ ucfirst($user->name) }}!</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @if ($posts->count() > 0)
            <div class="d-flex align-items-center justify-content-between my-5">
                <h3 class="fw-bold m-0" style="color: #396cb2;">
                    {{ ucfirst($user->name) }}'s Posts
                </h3>
                @if (Auth::user()->id == $user->id)
                    <a href="{{ route('post.user', $user->id) }}" class="btn btn-sm btn-custom" style="font-weight: 700;">
                        See All Your Posts
                    </a>
                @else
                    <a href="{{ route('post.user', $user->id) }}" class="btn btn-sm btn-custom" style="font-weight: 700;">
                        See All {{ ucfirst($user->name) }}'s Posts
                    </a>
                @endif
            </div>

            <div class="row g-4 post-card2">
                @foreach ($posts as $post)
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card post-card flex-fill shadow-sm position-relative">
                            @if ($post->visibility === 'private' && Auth::id() === $user->id)
                                <span class="badge text-white position-absolute m-2"
                                    style="z-index: 10; background-color: #396cb2; bottom: 45%; right: 0;">
                                    Private
                                </span>
                            @endif
                            @if ($post->image)
                                <div class="post-card-img-wrapper">
                                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->title }}"
                                        class="post-card-img">
                                </div>
                                @if (Auth::user()->id == $post->user->id)
                                
                                    <div class="dropdown post-img-actions">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                            id="postActionDropdown{{ $post->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false" style="border-radius: 50%; padding: 5px 8px;">
                                            <i class="fa-solid fa-ellipsis fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="postActionDropdown{{ $post->id }}">
                                            <li><a class="dropdown-item" href="{{ route('post.edit', $post->id) }}"><i
                                                        class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                            <li>
                                                <form action="{{ route('post.destroy', $post->id) }}" method="post"
                                                    class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i
                                                            class="fa-solid fa-trash-can me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endif

                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">
                                    <h5 class="card-title fw-bold mb-2" style="color: #27374D;">{{ $post->title }}</h5>
                                </a>
                                <p class="card-text text-muted mb-3" style="font-size: 0.9rem;">
                                    {{ Str::limit($post->body, 100, '...') }}
                                </p>
                                <a href="{{ route('post.show', $post->id) }}" class="mt-auto btn btn-sm btn-custom">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-flex justify-content-center mt-5">
                <div class="card about-me shadow-sm text-center p-4"
                    style="max-width: 320px; border-radius: 16px; background-color: #e8e9eb; {{ Auth::id() === $user->id ? 'border: 2px dashed #396cb2;' : '' }}">
                    <div class="mb-3">
                        <i class="fa-solid fa-folder-open text-muted" style="font-size: 48px;"></i>
                    </div>
                    <h5 class="mb-2 fw-semibold" style="color: #396cb2;">
                        @if (Auth::id() === $user->id)
                            No posts yet
                        @else
                            {{ ucfirst($user->name) }} hasn't posted yet
                        @endif
                    </h5>
                    <p class="mb-3 text-muted">
                        @if (Auth::id() === $user->id)
                            Once you create a post, it will appear here.
                        @else
                            Once {{ ucfirst($user->name) }} creates a post, it will appear here.
                        @endif
                    </p>
                </div>
            </div>
        @endif

    </div>

    <style>
        .user-profile-card {
            border-radius: 16px;
            background-color: #e8e9eb;
            /* width: 500px; */
            /* margin: auto */
        }

        /* Post Card */
        .post-card {
            border-radius: 16px;
            background-color: #ffffff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .post-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .post-card-img-wrapper {
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .post-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-card2 {
            width: 100%;
        }

        /* Custom Buttons */

        .user-profile-card a {
            background-color: #e8e9eb;
        }

        .btn-custom:hover {
            background-color: #396cb2;
            color: white;
            border: 2px solid #396cb2;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom {
            background-color: white;
            border-radius: 8px;
            color: #396cb2;
            border: 2px solid #396cb2;
        }

        .about-me {
            border: 2px dashed #27374D;
            transition: all 0.3s ease;
        }

        .about-me:hover {
            border: 2px solid #396cb2;
            /* background-color: #f0f4ff; */
            transform: translateY(-5px);
        }

        .post-img-actions {
            position: absolute;
            top: 10px;
            right: 10px;
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
