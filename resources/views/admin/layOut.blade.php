@php
use App\Http\Controllers\profileController;
$newId=profileController::getProfileInfo();
$name=profileController::getProfileName();  
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Navbar Replica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/assets/css/layout.css">
    @yield('css')
</head>
<body>
    <div class="fullBody">
        <nav>
            <div class="navbar">
                <div class="navbar-left">
                    <img src="/storage/img/newLogo.png" alt="Facebook Logo" class="facebook-logo">
                    <div class="search-bar">
                        <form action="/searchBar" method="post">
                            @csrf
                           
                            <input type="text" name='name' placeholder="Search your friend">
                        <button type="submit"> <i class="fas fa-search"></i></button></form>

                    </div>
                </div>
    
                <div class="navbar-center">
                    
                    <a href="/dashboard">
                        <div class="nav-icon">
                        <i class="fas fa-home"></i>
                    </div>
                </a>
                <a href="/friendRequest">
                    <div class="nav-icon">
                       <i class="fas fa-user-friends"></i>
                    </div>
                </a>
               
                    
                </div>
    
                <div class="navbar-right">
                    <div class="profile-section">
                        <a href="{{route('profile',['id'=>$name->id])}}">
                            @if($newId)
                            @if($newId->profile_photo_path)
                                <img  id='my_pp' src="{{ asset('storage/profiles/' . $newId->profile_photo_path) }}" alt="Profile Photo">
                            @else
                                <img  id='my_pp' src="{{ asset('storage/profiles/pp.png') }}" alt="Profile Photo">
                            @endif
                        @else
                            <img  id='my_pp' src="{{ asset('storage/profiles/pp.png') }}" alt="Profile Photo">
                        @endif
                        </a>
                           
                        
                        <span class="profile-name">{{$name->name}}</span>
                    </div>
                    
                    
                    <div class="nav-icon">
                        <div class="dropdown">
                            <button class="dropbtn">
                                <i class="fas fa-caret-down"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="/logout">Logout</a>
                                <a href="{{route('profile',['id'=>$name->id])}}">Profile</a>
                                <a href="{{route('dashboard')}}" @selected(true)>all post</a>
                                <a href="{{route('dashboardOfOnlyFriend')}}">Friends Only</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="bodyofEveryPage">
            @yield('FullBody')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navIcons = document.querySelectorAll('.nav-icon');

            navIcons.forEach(icon => {
                icon.addEventListener('click', function () {
                    // Remove active class from all icons
                    navIcons.forEach(icon => icon.classList.remove('active'));

                    // Add active class to the clicked icon
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
