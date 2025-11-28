@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="page-header text-center mb-4">
        <h1 style="color: #27374D; font-weight: 700;">Your Feed</h1>
        <p style="color: #526D82;">Catch up on the latest posts from your community</p>
    </div>

    <button type="button" class="fab-btn" data-bs-toggle="modal" data-bs-target="#createPostModal">
        <i class="fa-solid fa-plus fa-lg"></i>
    </button>

    {{-- @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
               
                var modalEl = document.getElementById('createPostModal');
                
                var myModal = bootstrap.Modal.getOrCreateInstance(modalEl);
              
                myModal.show();
            });
        </script>
    @endif --}}

    @include('posts.create')



    <div class="row justify-content-center gx-4 gy-4">
        @forelse ($all_posts as $post)
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="card post-card flex-fill">

                    @if ($post->image)
                        <div class="post-img-wrapper position-relative">
                            <a href="{{ route('post.show', $post->id) }}">
                                <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="post-image">
                                <div class="post-img-overlay">
                                    <h3 class="post-title-overlay">{{ $post->title }}</h3>
                                </div>
                            </a>

                            @if (Auth::user()->id == $post->user_id)
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
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        @if (!$post->image)
                            <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">
                                <h3 class="fw-bold post-title">{{ $post->title }}</h3>
                            </a>
                        @endif

                        <!-- Author & Date -->
                        <div class="mb-2 text-muted d-flex align-items-center">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none"
                                style="color: #27374D;"><i class="fa-solid fa-user me-1"></i> {{ $post->user->name }} </a>
                            <span class="mx-2">|</span>
                            <i class="fa-solid fa-calendar me-1"></i> {{ $post->created_at->format('M d, Y') }}
                        </div>

                        <!-- Post Body -->
                        <p class="post-body mb-3">
                            @if (strlen($post->body) > 120)
                                {!! Str::limit($post->body, 150, '...') !!}
                                <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none see-more">see
                                    more</a>
                            @else
                                {{ $post->body }}
                            @endif
                        </p>

                        {{-- <!-- Actions -->
                        @if (Auth::user()->id == $post->user_id)
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('post.destroy', $post->id) }}" method="post" class="d-inline">
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
            </div>
        @empty
            <div class="text-center mt-5 w-100" style="color: #526D82;">
                <h3>No Posts Yet</h3>
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    Create a new post
                </a>
            </div>
        @endforelse
    </div>

    <!-- Styles -->
    <style>
        .page-header h1 {
            font-size: 2.5rem;
        }

        .page-header p {
            font-size: 1rem;
        }

        /*
                    .fab-btn {
                        position: fixed;
                        bottom: 30px;
                        right: 30px;
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        background-color: #396cb2;
                        color: white;
                        border: none;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
                        cursor: pointer;
                        z-index: 1000;
                        transition: background-color 0.2s, transform 0.2s;
                    }

                    .fab-btn:hover {
                        background-color: #2f5390;
                        transform: translateY(-2px);
                    } */

        /* Post Cards */
        .post-card {
            border-radius: 16px;
            background-color: #ffffff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            min-height: 100%;
            /* ensures equal height */
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        /* Images */
        .post-img-wrapper {
            position: relative;
        }

        .post-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .post-img-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
            color: white;
            padding: 10px 15px;
        }

        .post-title-overlay {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }

        /* Card Body */
        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .post-title {
            font-size: 1.25rem;
            color: #27374D;
            margin-bottom: 0.5rem;
        }

        .post-body {
            color: #27374D;
            line-height: 1.5;
            font-size: 1rem;
        }

        .see-more {
            color: #396cb2;
            font-style: italic;
            text-decoration: underline;
        }

        /* Author & Date */
        .card-body .text-muted {
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
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

        /* Responsive grid */
        @media (min-width: 992px) {
            .col-lg-4 {
                flex: 0 0 33.3333%;
                max-width: 33.3333%;
            }
        }

        @media (max-width: 991px) {
            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 767px) {
            .col-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .post-image {
                height: 200px;
            }
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
