@extends('admin.layOut')
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
    use App\Http\Controllers\profileController;
    use App\Http\Controllers\postController;
    use App\Models\profileModel;

     $photo=profileController::getProfileInfo();
    if($photo!=null){
        $id=$photo->user_id;
    }
    
   
   
  
   
@endphp


@section('css')
<link rel="stylesheet" href="\build\assets\css\Dashboard.css">

<style>
   .commentArea {
    margin-top: 10px; /* Optional: Add some space between the button and the comment box */
    width: 100%; /* Ensure it spans the container's width */
}


.comment {
    display: flex;
    align-items: flex-start;
    padding: 10px;
    background-color: #f0f2f5; /* Light Facebook gray background */
    border-radius: 18px; /* Rounded corners */
    margin-bottom: 10px;
    max-width: 600px; /* Set max-width similar to Facebook */
    font-family: Arial, sans-serif;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
}

#comment-profile-photo {
    width: 40px; /* Facebook-like profile image size */
    height: 40px;
    border-radius: 50%; /* Make the profile photo round */
    margin-right: 10px; /* Space between photo and text */
    object-fit: cover; /* Ensure the image fits the container */
}

.comment-content {
    display: flex;
    flex-direction: column;
    background-color: white;
    padding: 8px 12px;
    border-radius: 12px; /* Bubble effect around the comment */
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Subtle shadow */
}

.comment-username {
    color: #385898; /* Facebook blue for the username */
    font-weight: bold;
    margin-bottom: 2px; /* Space between username and comment */
}

.comment-text {
    color: #1c1e21; /* Default Facebook text color */
    font-size: 14px;
}

</style>
@endsection
@section('FullBody')
<script src="/build/assets/js/admindash.js"></script>
<div class="mainContainer">
    <!-- Left Sidebar -->
   

    <!-- Middle Page (Main Feed) -->
    <div class="middlePage" >
      
            
       
        <!-- Create Post Section -->
        <form class="create-post-container" action="/postMyPost" method="post" enctype="multipart/form-data">
            @csrf
        
            <div class="create-post-header">
                @if ($photo!=null)
                <img src="{{ asset('storage/profiles/' . $photo->profile_photo_path) }}" alt="User Profile" class="profile-pic">
                    
                @else
                <img src="{{asset('storage/profiles/pp.png')}}" alt="User Profile" class="profile-pic">
                @endif
                <input type="text" name="title" placeholder="Title" class="post-input" required>
            </div>
        
            <hr>
        
            <div class="create-post-description">
                <h3>Description</h3>
                <textarea type="text" name="description" placeholder="Write a short description about your post" class="post-description-input" id="descriptionTextarea" required></textarea>
            </div>
        
            <hr>
        
            <div class="create-post-actions">
                <label for="file-input" class="action-button photo">
                    <i class="fas fa-image"></i> Photo/Video
                </label>
        
                <input type="file" name="image" id="file-input" accept="image/*" style="display: none" onchange="previewImage(event, 'newImagePreview')" required/>
        
              
            </div>
        
            <!-- Preview Image Section -->
            <div class="mt-3" id="imagePreviewContainer" style="position: relative;">
                <img id="newImagePreview" src="#" alt="New Image Preview" style="max-width: 200px; display: none;">
                <!-- Unselect Button -->
                <button type="button" id="removeImageButton" style="position: absolute; top: 0; right: 0; background: rgba(255, 255, 255, 0.8); border: none; border-radius: 50%; padding: 5px; cursor: pointer; display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        
            <div class="create-post-footer">
                <button class="post-button" type="submit">Post</button>
            </div>
        </form>
        
       

        <!-- Posts Feed Section (Sample Posts) -->
       
@if ($posts && $posts->isNotEmpty())
<div class="post-feed">
    
    @foreach ($posts as $userPost)

        @php
            $myimage=profileController::getUser($userPost->user_id);
            $validThing=profileModel::where('user_id',$userPost->user_id)->first();
            $profileImage=$validThing->profile_photo_path;
            $validUsers=postController::postEditor($userPost->id);
          
        @endphp
     <!-- Inside your foreach loop for posts -->
<div class="post">
    <!-- Post Header -->
    <div class="post-header">
        <img src={{ asset('storage/profiles/'.$profileImage) }} alt="Friend Profile" class="profile-pic">
        <div class="post-user-info">
            <strong>{{ $myimage->name }}</strong>
            <span>5 mins ago</span>
        </div>
    </div>

    <!-- Post Content -->
    <div class="post-content">
        @if ($validUsers)
        <div class="options-menu">
            <button class="optionsMenuBtn" data-post-id="{{ $userPost->id }}"><i class="fas fa-ellipsis-h"></i></button>
            <div class="options-menu-content" id="optionsMenuContent-{{ $userPost->id }}">
                <a href="{{ route('posts.edit', ['id'=>$userPost->id]) }}">Edit</a>
                <a href="{{ route('posts.destroy', $userPost->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $userPost->id }}').submit();">Delete</a>
                <form id="delete-form-{{ $userPost->id }}" action="{{ route('posts.destroy',['id'=>$userPost->id]) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
            
        @endif
        <!-- Options Menu (Three Dots) -->
       

        <h3>{{ $userPost->title }}</h3>
        {!! nl2br(e($userPost->description)) !!}
    
        @if ($userPost->image) <!-- Check if image exists -->
            <img src="{{ asset('storage/images/' . $userPost->image) }}" alt="Post Image" class="post-image">
        @else
            <p>No image available.</p>
        @endif
       
        <div id="likes-{{ $userPost->id }}" class="likes">
            
        </div>
    
        <div class="post-actions">
           
            <form>
                @csrf

                {{-- data-post-id="{{ $userPost->id }} " --}}
                <button type="submit" class="like-btn likeSender" data-id="{{ $userPost->id }}">
                    <i class="fas fa-thumbs-up"></i> Like
                </button>
            </form>
           
           
            
            
                
            <button id="commentBtn" class="commentBtn" onclick="showComment({{ $userPost->id }})" data-comment-id="{{ $userPost->id }}">
                <i class="fas fa-comment"></i> Comment
            </button>
            <button><i class="fas fa-share"></i> Share</button>
            <br><br>
            
            
    </div>
    <form action="{{route('sendComment',['id'=>$userPost->id])}}" method="POST">
    @csrf
    <div class="commentArea" id="commentArea-{{ $userPost->id }}" style="display: none; position: relative;">
        <textarea class="commentarea" id="myComment-{{ $userPost->id }}" name="comment" rows="4" placeholder="Write a comment..." style="width: 100%;"></textarea>
        <button class="send-btn" id="sendComment-{{ $userPost->id }}">Send</button>
        <div class="comments">
            

            <div id="comments-section-{{ $userPost->id }}" class="comments-section"></div>
        </div>
    </div>
   </form>
    
</div>
</div>
    @endforeach
</div>
@endif
    
    </div>

    <!-- Right Sidebar -->

  
    
         
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            
            
         <script>
                  document.addEventListener('DOMContentLoaded', function() {
            // Handle click for all options menu buttons
            document.querySelectorAll('.optionsMenuBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const content = document.getElementById(`optionsMenuContent-${postId}`);
                    
                    // Hide other open menus
                    document.querySelectorAll('.options-menu-content').forEach(menu => {
                        if (menu !== content) {
                            menu.style.display = 'none';
                        }
                    });
                    
                    // Toggle the visibility of the clicked menu
                    content.style.display = content.style.display === 'block' ? 'none' : 'block';
                });
            });
        
            // Optional: Hide dropdown menu if clicked outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.options-menu')) {
                    document.querySelectorAll('.options-menu-content').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });
        });
            function previewImage(event, previewId) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var output = document.getElementById(previewId);
                        var removeButton = document.getElementById('removeImageButton');
                        output.src = e.target.result;
                        output.style.display = 'block';
                        removeButton.style.display = 'block'; // Show the remove button
                    };
                    reader.readAsDataURL(file);
                }
            }
        
            document.getElementById('removeImageButton').addEventListener('click', function() {
                var fileInput = document.getElementById('file-input');
                var previewImage = document.getElementById('newImagePreview');
                var removeButton = document.getElementById('removeImageButton');
        
                fileInput.value = ''; // Clear the file input
                previewImage.src = '#'; // Reset the preview image
                previewImage.style.display = 'none'; // Hide the preview image
                removeButton.style.display = 'none'; // Hide the remove button
            });
            $(document).ready(function() {

                function countLikes(id){
                    $.ajax({
                        type: "POST",
                        url: "{{route('displayLikes')}}",
                        data: {
                            id:id,
                            _token: '{{csrf_token()}}',
                        },
                        success: function(data){
                            $('#likes-'+id).html(data);
                        }


                    });

                }

               $('.likes').each(function() {
                    var userId = $(this).attr('id').split('-')[1]; 
                   countLikes(userId);  
                });

              
                $(document).on('click', '.likeSender', function(e) {
                    e.preventDefault();  // Prevent form submission
        
                    var id = $(this).data('id');  // Fetch post ID from data attribute
                    console.log(id);  
                    $.ajax({
                        url: '{{ route('sendLike') }}',  // Route for handling likes
                        type: 'POST',
                        data: {
                            id: id,  // Send the post ID
                            _token: '{{ csrf_token() }}'  // Include CSRF token
                        },
                        success: function(data) {
                           countLikes(id);
                            console.log(data);  // Debugging: Success message
                            // You can add code here to update the UI, e.g., incrementing the like count
                        },
                        error: function(xhr, status, error) {
                            console.log('Error:', error);  // Debugging: Log the error
                            console.log('Status:', status);  // Debugging: Log the status
                            console.log('Response:', xhr.responseText);  // Debugging: Log server response
                        }
                    });
                });
            });
        </script>
       
        
@endsection
