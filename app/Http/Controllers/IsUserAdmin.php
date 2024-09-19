<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserAdmin extends Controller
{
   public function checkUserType(){
    if(Auth::user()->id){
       
       

        $allpost=post::orderBy('id','desc')->get();


       

            return view("admin.adminDashboard")->with(['posts'=>$allpost]);
       
    }
   } 
}
