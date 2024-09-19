@php
    use App\Http\Controllers\profileController;
    use App\Models\profileModel;
     $photo=profileController::getProfileInfo();
   
   
   $id=$photo->user_id;
   
@endphp

@if ($posts && $posts->isNotEmpty())
<div class="post-feed">
    
    @foreach ($posts as $userPost)
        @php
            $myimage=profileController::getUser($userPost->user_id);
            $validThing=profileModel::where('user_id',$userPost->user_id)->first();
            $profileImage=$validThing->profile_photo_path;
          
        @endphp
        <div class="post">
            {{-- <p> {{$userPost->id}} </p>
            <p>{{$validThing}}</p>
            <p> {{$profileImage}} </p> --}}
            <div class="post-header">
                <img src={{ asset('storage/profiles/'.$profileImage) }} alt="Friend Profile" class="profile-pic">
                <div class="post-user-info">
                    <strong>
                   {{$myimage->name}}   
                    </strong> <!-- Assuming you have a user relationship -->
                    <span>5 mins ago</span>
                </div>
            </div>
            <div class="post-content">
                <!-- Options Menu (Three Dots) -->
                <div class="options-menu">
                    <button id="optionsMenuBtn"><i class="fas fa-ellipsis-h"></i></button>
                    <div class="options-menu-content">
                        <a href="{{ route('posts.edit', $userPost->id) }}">Edit</a>
                        <a href="{{ route('posts.destroy', $userPost->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $userPost->id }}').submit();">Delete</a>
                        <form id="delete-form-{{ $userPost->id }}" action="{{ route('posts.destroy', $userPost->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            
                <!-- Post Content -->
                <h3>{{ $userPost->title }}</h3>
                {!! nl2br(e($userPost->description)) !!}
            
                @if ($userPost->image) <!-- Check if image exists -->
                    <img src="{{ asset('storage/images/' . $userPost->image) }}" alt="Post Image" class="post-image">
                @else
                    <p>No image available.</p>
                @endif
            
                <div class="post-actions">
                    <button><i class="fas fa-thumbs-up"></i> Like</button>
                    <button id="commentBtn"><i class="fas fa-comment"></i> Comment</button>
                    <button><i class="fas fa-share"></i> Share</button>
                </div>
                
                <div class="comment-area" id="commentArea">
                    <textarea id="myComment" rows="4" placeholder="Write a comment..."></textarea>
                </div>
            </div>
            
        </div>
    @endforeach
</div>
@endif