@extends('admin.layOut')

@section('css')
    <link rel="stylesheet" href="/build/assets/css/profileForm.css">
@endsection

@section('FullBody')
<div class="profile-form-container">
    <h2>Complete Your Profile</h2>
    <form method="POST" action="{{route('completeProfile')}}" enctype="multipart/form-data">
        @csrf
        <!-- Personal Information -->
        <div class="form-section">
            <h3>Personal Information</h3>
            

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" id="dob"  @if ($user->date_of_birth!=null)
                value="{{$user->date_of_birth}}"                  
                @endif required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    
                    <option value="">Select Gender</option>
                    <option value="male" 
                    @if ($user->gender=="male")
                    selected
                        
                    @endif
                    >Male</option>
                    <option value="female"
                    @if ($user->gender=="female")
                    selected
                        
                    @endif
                    >Female</option>
                    <option value="other"
                    @if ($user->gender=="others")
                    selected
                        
                    @endif
                    >Other</option>
                </select>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="form-section">
            <h3>Contact Information</h3>
          

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" placeholder="Enter your phone number" 
                @if ($user->phone!=null)
                value="{{$user->phone}}"
                @endif
                required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" placeholder="Enter your address"
                @if ($user->phone!=null)
                value="{{$user->address}}"                  
                @endif
                required>
            </div>
        </div>

        <!-- Profile Picture -->
        <div class="form-section">
            <h3>Profile Picture</h3>
            <div class="form-group">
                <label for="photo">Upload Profile Picture</label>
                <input type="file" name="photo" id="photo" accept="image/*">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group submit-button">
            <button type="submit">Save Profile</button>
        </div>
    </form>
</div>
@endsection
