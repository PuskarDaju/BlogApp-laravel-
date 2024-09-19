@php
    use App\Http\Controllers\ConnectionController;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('admin.layOut')
@section('css')
    <link rel="stylesheet" href="/build/assets/css/friendRequest.css">
@endsection
@section('FullBody')
    @foreach ($Names as $name)
    @if ($name['id'] != Auth::id())
    @php
        $ids = ConnectionController::checkSentRequest();
        $num = ConnectionController::checkRequests($name['id']);
    @endphp

    @if ($num == 1)
        <div class="friend-card">
            <div class="friend-image">
                @php
                    $pic = ConnectionController::getFriendImage($name['id']);

                @endphp
              
                
                @if (empty($pic) || empty($pic->profile_photo_path))
                    <img src="{{ asset('storage/profiles/abc.png') }}" alt="Default Profile Picture">
                @else
                    <img src="{{ asset('storage/profiles/' . $pic->profile_photo_path) }}" alt="Profile Picture">
                @endif
            </div>
            
            <div class="friend-info">
                <h5>{{ $name['name'] }}</h5>
                <p class="mutual-friends">2 mutual friends</p> {{-- You can dynamically fetch mutual friends if needed --}}
                <form action="{{ route('sentfriendRequest', ['id' => $name['id']]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-add-friend" name="sendRequest">
                        <div class='icon'>Add Friend</div>
                    </button>
                </form>
            </div>
        </div>
    @endif
@endif
        
    @endforeach
        @endsection
</html>