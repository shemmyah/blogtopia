@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container my-5 d-flex justify-content-center">
    <div class="card shadow-sm p-4 mb-4 mx-auto" style="border-radius: 16px; max-width: 600px; width: 100%;">
        <h2 class="fw-bold mb-4" style="color: #27374D;">Edit Profile</h2>

        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                @if ($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}"
                        class="rounded-circle mb-3"
                        style="width: 150px; height:150px; object-fit: cover; border:3px solid #396cb2;">
                @else
                    <div class="d-flex justify-content-center align-items-center rounded-circle mb-3"
                        style="width:150px; height:150px; background:#e4eafa; border:3px solid #396cb2;">
                        <i class="fa-solid fa-user fa-3x text-muted"></i>
                    </div>
                @endif

                <input type="file" name="avatar" class="form-control w-100" aria-describedby="avatar-info">
                <div class="form-text mt-1" id="avatar-info">
                    Acceptable formats: jpeg, png, gif <br>
                    Max size: 1MB
                </div>

                @error('avatar')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold" style="color:#396cb2;">Name</label>
                <input type="text" name="name" id="name" class="form-control w-100"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold" style="color:#396cb2;">Email</label>
                <input type="email" name="email" id="email" class="form-control w-100"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- About Me Section -->
            <div class="mb-3">
                <label for="about" class="form-label fw-semibold" style="color:#396cb2;">About Me</label>
                <textarea name="about" id="about" rows="6" class="form-control w-100" placeholder="Add your bio">{{ old('about', $user->about) }}</textarea>
                @error('about')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-custom px-5">Save</button>
        </form>
    </div>
</div>

<style>
    /* Custom button styling with hover fill */
    .btn-custom {
        background-color: white;
        border: 2px solid #396cb2;
        border-radius: 8px;
        color: #396cb2;
        transition: 0.3s;
    }

    .btn-custom:hover {
        background-color: #396cb2;
        color: white;
    }
</style>

@endsection
