<!-- Create Post Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4" style="border-radius: 16px; background-color: #e4eafa;">

            <!-- Modal Header -->
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="createPostModalLabel" style="color: #27374D;">Create a Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2">
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control transparent-input"
                            placeholder="Post title..." value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Body -->
                    <div class="mb-3">
                        <textarea name="body" rows="4" class="form-control transparent-input"
                            placeholder="What's on your mind, {{ Auth::user()->name }}?">{{ old('body') }}</textarea>
                        @error('body')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <input type="file" name="image" id="modalImageInput" class="d-none" accept="image/*">


                    <div class="mb-3">
                        {{-- <label for="visibility" class="form-label fw-semibold">Visibility</label> --}}
                        <select name="visibility" id="visibility" class="form-select transparent-input">
                            <option value="" hidden>Choose visibility</option>
                            <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private
                            </option>
                        </select>
                        @error('visibility')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="button" onclick="document.getElementById('modalImageInput').click();"
                            class="btn btn-image d-flex align-items-center mb-2"
                            style="border: 1px solid #0a2747; border-radius: 12px;">
                            <i class="fa-solid fa-image me-2"></i> Add Image
                        </button>
                        @error('image')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        <div id="modalImagePreview" class="d-none mt-2"
                            style="width: 120px; height: 120px; border-radius: 12px;">
                            <img id="modalPreviewImg" src="" class="img-fluid w-100" style="object-fit: cover;">
                        </div>

                    </div>


                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-submit fw-semibold"
                            style="border-radius: 12px; padding: 12px;">Post</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .btn-submit {
        background-color: #396cb2;
        color: #e4eafa;
    }

    .btn-submit:hover {
        background-color: #072352;
        color: #e4eafa;
        transition: all 0.3s ease;
    }

    .btn-image {
        background-color: #e4eafa;
        color: #072352;
        opacity: 1
    }

    .btn-image:hover {
        background-color: #072352;
        color: #e4eafa;
        transform: translateY(-3px);
        transition: all 0.3s ease;
    }

    .transparent-input {
        background-color: #e4eafa;
        border-radius: 12px;
        padding: 12px;
        border: 1px solid #0b2b46;
        color: #27374D;
    }

    .transparent-input::placeholder {
        color: #072352;
        opacity: 1;
    }

    .transparent-input:focus {
        box-shadow: 0 0 0 2px rgba(57, 108, 178, 0.3);
        outline: none;
    }
</style>

<!-- JS: Image Preview -->
<script>
    document.getElementById('modalImageInput').addEventListener('change', function(event) {
        const preview = document.getElementById('modalImagePreview');
        const img = document.getElementById('modalPreviewImg');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                img.src = reader.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });
</script>
