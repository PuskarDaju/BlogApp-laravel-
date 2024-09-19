<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use App\Models\profileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function createProfile(Request $request){
        //check if user has a profile picture
        $pp=profileModel::where('user_id',Auth::id())->first();

            
       $validProfile= validator::make(
            $request->all(),
            [
                'dob'=>'required',
                'gender'=>'required',
                'phone'=>'required|numeric',
                'address'=>'required',
                'photo'=>'required'

            ]
            );
            if($validProfile->fails()){
                echo "Please enter valid information And don't try to fuck with me this app is not going as i thought";
                echo "<br>";
                echo $validProfile->errors();
            }else{
                if ($request->hasFile('photo')) {
                    if($pp->profile_photo_path!="pp.png" || $pp->profile_photo_path!=null){
                        if (Storage::exists('public/profiles/'.$pp->profile_photo_path)) {
                            // Delete the file
                            Storage::delete('public/profiles/'.$pp->profile_photo_path);
                        }
                    }
                    // Generate a unique filename with timestamp and the original file's extension
                    $fileName = time() . "_" . $request->photo->getClientOriginalName();
                    echo $fileName;
                    
                    // Store the file in the public/images directory
                    $filePath = $request->file('photo')->storeAs('public/profiles', $fileName);
                    profileModel::where('user_id',Auth::id())->update([                       
                        'date_of_birth' => $request->dob,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'profile_photo_path' => $fileName,
         
                    ]);
                }
                
              
                return redirect()->route('dashboard');
            }
      
    }
    public static function getProfileInfo(){
       
        $profile=profileModel::where('user_id',Auth::id())->first();

        return $profile;
    }
    public static function getProfileName(){
        $Name=User::find(Auth::id());

        return $Name;
    }
    public static function getUser($id){
        $Name=User::where('id',$id)->first();

        return $Name;
    }
    public static function getProfilePhotoOfPost($id){
        $photo=post::where(['id'=>$id])->first();
        return $photo;
    }
}
