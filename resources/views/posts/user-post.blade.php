@extends('layouts.app')

@section('title', $user->name . "'s Posts")

@section('content')

    <div class="container">
        <!-- Back Icon -->
        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none mb-4 d-inline-block back-icon"
            style="color: #396cb2; font-size: 1.5rem;">
            <i class="fa fa-arrow-left"></i>
        </a>



        <!-- Header -->
        <div class="d-flex align-items-start mb-3">
            {{-- <i class="bi bi-journal-text fs-1 me-3" style="color:#396cb2;"></i> --}}

            <div>
                <h2 class="fw-bold m-0" style="color:#27374D;">
                    {{ ucfirst($user->name) }}'s Posts
                </h2>

                <p class="text-muted mt-1 mb-0" style="font-size: 0.95rem;">
                    Showing <strong>{{ $posts->count() }}</strong>
                    {{ Str::plural('post', $posts->count()) }} from {{ $user->name }}.
                </p>
            </div>
        </div>



        <!-- If no posts -->
        @if ($posts->isEmpty())
            <div class="d-flex justify-content-center mt-5">
                <div class="card about-me shadow-sm text-center p-4"
                    style="max-width: 350px; border-radius: 16px; background-color: #e8e9eb;">
                    <div class="mb-3">
                        <i class="fa-solid fa-folder-open text-muted" style="font-size: 48px;"></i>
                    </div>
                    <h5 class="fw-semibold" style="color: #396cb2;">
                        {{ ucfirst($user->name) }} hasn't posted yet
                    </h5>
                    <p class="text-muted mb-0">Please check back later!</p>
                </div>
            </div>
        @else
            <!-- Post Grid -->
            <div class="row g-4">
                @foreach ($posts as $post)
                    @if ($post->visibility === 'public' || Auth::id() === $user->id)
                        <div class="col-12 col-md-6 col-lg-4 d-flex">
                            <div class="card post-card flex-fill shadow-sm">

                                <!-- Post Image -->
                                @if ($post->image)
                                    @if ($post->visibility === 'private' && Auth::id() === $user->id)
                                        <span class="badge text-white position-absolute m-2"
                                            style="z-index: 10; background-color: #396cb2; bottom: 45%; right: 0;">
                                            Private
                                        </span>
                                    @endif
                                    <div class="post-card-img-wrapper">
                                        <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->title }}"
                                            class="post-card-img">
                                    </div>
                                @endif

                                <!-- Post Body -->
                                <div class="card-body d-flex flex-column">
                                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">
                                        <h5 class="card-title fw-bold mb-2" style="color:#27374D;">
                                            {{ $post->title }}
                                        </h5>
                                    </a>

                                    <p class="card-text text-muted mb-3" style="font-size: 0.9rem;">
                                        {{ Str::limit($post->body, 100, '...') }}
                                    </p>

                                    <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-custom mt-auto">
                                        Read More
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        @endif

    </div>

    <style>
        .back-icon i {
            font-size: 1.5rem;
            color: #396cb2;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .back-icon:hover i {
            transform: scale(1.3);
            color: #27374D;
        }


        .post-card {
            border-radius: 16px;
            background-color: #ffffff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
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

        .btn-custom {
            background-color: white;
            border-radius: 8px;
            color: #396cb2;
            border: 2px solid #396cb2;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #396cb2;
            color: white;
            border: 2px solid #396cb2;
        }
    </style>

@endsection
