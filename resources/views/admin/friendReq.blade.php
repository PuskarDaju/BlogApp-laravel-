
@php
    use App\Http\Controllers\ConnectionController;
    use Illuminate\Support\Facades\Auth;
    
@endphp
@extends('admin.layOut')

@section('css')
    <link rel="stylesheet" href="/build/assets/css/friendRequest.css">
@endsection

@section('FullBody')


@if($fReqs->isNotEmpty())

<div class="myRequests">
    <h1>Friend Requests</h1>
   
        
   
    @foreach ($fReqs as $req)
    

    @php
        $sentIds=ConnectionController::checkSentRequest();
       $name= ConnectionController::getFriendName($req->id1);
       $photo= ConnectionController::getFriendImage($req->id1);
       
    @endphp

        
    

    

        
   
    <div class="friend-card">
      
        <div class="friend-image">
           
            <img src="{{ asset('storage/profiles/'.$photo->profile_photo_path) }}" alt="no image">
        </div>
        <div class="friend-info">
            <h5>{{ $name->name }}</h5>
            <p class="mutual-friends">2 mutual friends</p> {{-- You can dynamically fetch mutual friends if needed --}}
            <form action="{{ route('acceptfriendRequest', ['id' => $req->id1]) }}" method="POST">
                @csrf
                <button type="submit" class="btn-add-friend" name="sendRequest">
                    <div class='icon'>Accept</div>
                </button>
            </form>
            <form action="{{ route('deletefriendRequest', ['id' => $req->id1]) }}" method="POST">
                @csrf
                <button type="submit" class="btn-add-friend" name="sendRequest">
                    <div class='icon'>Delete</div>
                </button>
            </form>
            
        </div>
    </div> 
    @endforeach
</div>

<hr>
    @endif


   

<div class="friends-list">
    @php
     $Fids = ConnectionController::myFriends();
     
     @endphp

     @if ($Fids->isNotEmpty())
     <h1>MY Friends</h1>
        @foreach ($Fids as $ids)
       
        <div class="friend-card">
          
            <div class="friend-image">
                @php
                    $pic = ConnectionController::getFriendImage($ids);
                    $fnames=ConnectionController::getFriendName($ids);
                @endphp
               
                
                @if (empty($pic) || empty($pic->profile_photo_path))
                    <img src="{{ asset('storage/profiles/abc.png') }}" alt="Default Profile Picture">
                @else
                    <img src="{{ asset('storage/profiles/' . $pic->profile_photo_path) }}" alt="Profile Picture">
                @endif
            </div>
            
            <div class="friend-info">
                <h5>{{ $fnames->name }}</h5>
                <p class="mutual-friends">2 mutual friends</p> {{-- You can dynamically fetch mutual friends if needed --}}
                <form action="{{ route('deletefriendRequest', ['id' => $ids]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-add-friend" name="sendRequest">
                        <div class='icon'>Delete</div>
                    </button>
                </form>
                </form>
            </div>
        </div>
            
        @endforeach
    </div>
    <hr>
         
     @endif
        
    


<div class="friends-list">

    <h1>Other Users</h1>
    

   
    
    @foreach ($data as $profile)
        @if ($profile->id != Auth::id())
            @php
                $ids = ConnectionController::checkSentRequest();
                $num = ConnectionController::checkRequests($profile->id);
            @endphp

            @if ($num == 1)
                <div class="friend-card">
                    <div class="friend-image">
                        @php
                            $pic = ConnectionController::getFriendImage($profile->id);
                        @endphp
                       
                        
                        @if (empty($pic) || empty($pic->profile_photo_path))
                            <img src="{{ asset('storage/profiles/abc.png') }}" alt="Default Profile Picture">
                        @else
                            <img src="{{ asset('storage/profiles/' . $pic->profile_photo_path) }}" alt="Profile Picture">
                        @endif
                    </div>
                    
                    <div class="friend-info">
                        <h5>{{ $profile->name }}</h5>
                        <p class="mutual-friends">2 mutual friends</p> {{-- You can dynamically fetch mutual friends if needed --}}
                        <form action="{{ route('sentfriendRequest', ['id' => $profile->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-add-friend" name="sendRequest">
                                <div class='icon'>Add Friend</div>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        @endif
    @endforeach

   


@endsection