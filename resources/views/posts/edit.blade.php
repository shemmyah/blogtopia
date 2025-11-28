@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm p-4" style="border-radius: 16px; max-width: 700px; margin: auto;">
        <h3 class="fw-bold mb-4 text-primary">Edit Post</h3>

        <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="title" class="form-label text-secondary">Title</label>
                <input type="text" name="title" id="title" class="form-control" 
                       placeholder="Enter title here" value="{{ old('title', $post->title) }}" autofocus>
                @error('title')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Body -->
            <div class="mb-3">
                <label for="body" class="form-label text-secondary">Body</label>
                <textarea name="body" id="body" rows="5" class="form-control" 
                          placeholder="Start writing...">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="visibility" class="form-label text-secondary">Visibility</label>
                <select name="visibility" id="visibility" class="form-select">
                    <option value="public" {{ old('visibility', $post->visibility) === 'public' ? 'selected' : '' }}>Public</option>
                    <option value="private" {{ old('visibility', $post->visibility) === 'private' ? 'selected' : '' }}>Private</option>
                </select>
                <div class="form-text">
                    Private posts will only be visible to you when logged in.
                </div>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label text-secondary">Image</label>
                <div class="mb-2">
                    <img id="imagePreview" src="{{ asset('storage/images/' . $post->image) }}" 
                         alt="{{ $post->title }}" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: cover;">
                </div>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <div class="form-text">
                    Acceptable formats: jpeg, jpg, png, gif. Max size: 1048kB.
                </div>
                @error('image')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>


            <div class="d-flex justify-content-end">
                <a href="{{ route('post.show', $post->id) }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-5">Save</button>
            </div>
        </form>
    </div>
</div>


<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = () => preview.src = reader.result;
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
