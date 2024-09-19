<?php

namespace App\Http\Controllers;

use App\Models\connection;
use App\Models\post;
use App\Models\profileModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminButtonController extends Controller
{
    

    public function dashWithFriend(){
     
      $fids=ConnectionController::myFriends();
      $posts=post::whereIn('user_id',$fids)->get();
      return view('admin.adminDashboard',compact('posts'));
      
    }
    public function logMeOut(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
    public function friendReq(){
        $fReqs=connection::where('id2',Auth::id())->where('status','pendingFriend')->get();
       $data=User::get();
        if($data!=null || !empty($data)){
        return view('admin.friendReq',compact('data','fReqs'));
    }else{
        echo "noRequests";

    }}

    public function completeProfile(Request $request){
        $user=profileModel::where('user_id',$request->id)->first();
        if($user==null){
            
            $user=profileModel::where('user_id',$request->id)->first();


        }
        return view('admin.completeProfile')->with("user",$user);

    }
    public function searchFriend(Request $request) {
        $name=$request->name;
        $Names=User::where('name',$name)->get()->toArray();

        return view('admin.seachedfr',compact("Names"));
    }
}
