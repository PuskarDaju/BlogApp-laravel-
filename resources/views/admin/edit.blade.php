@extends('admin.layOut')
@section('css')
<link rel="stylesheet" href="/build/assets/css/edit.css">
@endsection

@section('FullBody')
<div class="container">
    <h2>Edit Post</h2>

    <!-- Display validation errors if any -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Post Form -->
<form action="{{route('updateMyPost',['id'=>$post->id])}}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Title Field -->
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
    </div>

    <!-- Description Field -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $post->description) }}</textarea>
    </div>

    <!-- Photo Field -->
    <div class="form-group">
        <label for="image">Upload New Photo</label>
        <input type="file" class="form-control-file" id="image" name="image" onchange="previewImage(event, 'currentImage', 'newImagePreview')">
    
        <!-- Display current photo -->
        @if($post->image)
            <div class="mt-3">
                <img id="currentImage" src="{{ asset('storage/images/' . $post->image) }}" alt="Post Image" style="max-width: 200px;">
            </div>
        @endif
    
        <!-- Preview new image -->
        <div class="mt-3">
            <img id="newImagePreview" src="#" alt="New Image Preview" style="max-width: 200px; display: none;">
        </div>
    </div>

    <!-- Second Photo Field for another image -->
    <div class="form-group">
        <label for="secondImage">Upload Another Photo</label>
        <input type="file" class="form-control-file" id="secondImage" name="secondImage" onchange="previewImage(event, 'secondCurrentImage', 'secondImagePreview')">
    
        <!-- Display second current photo (optional) -->
        @if($post->second_image)
            <div class="mt-3">
                <img id="secondCurrentImage" src="{{ asset('storage/images/' . $post->second_image) }}" alt="Second Post Image" style="max-width: 200px;">
            </div>
        @endif
    
        <!-- Preview new second image -->
        <div class="mt-3">
            <img id="secondImagePreview" src="#" alt="Second Image Preview" style="max-width: 200px; display: none;">
        </div>
    </div>

    <!-- JavaScript to handle image preview -->
    <script>
        function previewImage(event, currentImageId, newImagePreviewId) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById(newImagePreviewId);
                output.src = reader.result;
                output.style.display = 'block'; // Show the new image preview
            };
            reader.readAsDataURL(event.target.files[0]);

            // Optionally, hide the current image when a new one is selected
            var currentImage = document.getElementById(currentImageId);
            if(currentImage) {
                currentImage.style.display = 'none';
            }
        }
    </script>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Update Post</button>
</form>

</div>
@endsection
