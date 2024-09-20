<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use App\Models\connection;
use App\Models\profileModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConnectionController extends Controller
{
    public function friendRequest(Request $req){
        $id1=Auth::id();
        $fReq=connection::create([
            'id1'=>$id1,
            'id2'=>$req->id,
            'sentBy'=>$id1,
            'status'=>'pendingFriend',
        ]);
        if($fReq){
            return redirect()->route('dashboard');
        }else{
            echo "unable to send request";
        }
        
    }
    public function acceptRequest(Request $request){
        $id1=$request->id;
        

        $acceptedReq=connection::where('id1',$id1)->where('id2',Auth::id())->where('status','pendingFriend')->update([
            'status'=>"friend",
        ]);
        if($acceptedReq){
            return redirect()->route('friendRequest');
        }else{
            return redirect()->route('dashboard');
        }

    }
    public function deleteRequest(Request $req){
        $id1=Auth::id();
        $id2=$req->id;
        $del=connection::where('id2',$id1)->where('id1',$id2)->delete();
        
        if($del){
            return redirect()->route('friendRequest');
        }else{
            echo "unable to delete the Request";
        }

    }
    public static function getFriendName($id){
        $Name=User::find($id);
        return $Name;
    }
    public static function getFriendImage($id){
        $Name=profileModel::where('user_id',$id)->get('profile_photo_path')->first();
        return $Name;
    }
    public static function checkSentRequest(){
        $id=connection::where('sentBy',Auth::id())->get();
        
            return $id;
        
    }
    public static function checkReceivedRequest(){
        $id=connection::where("id2",Auth::id())->get();
        return $id;
    
    }
    public static function checkRequests($id2){
        $id = self::checkSentRequest()->pluck('id2')->toArray();
        $id3 = self::checkReceivedRequest()->pluck('id1')->toArray();
        
        // Check if $id2 is in either $id or $id3
        if (in_array($id2, $id) || in_array($id2, $id3)) {
            return 0;
        } else {
            return 1;
        }
    }
    public function deleteMyPost(Request $request) {
        $post12 = Post::find($request->id); // Correcting the parameter syntax for find() method
    
        if ($post12) {
            // Path to the image
            $imagePath = public_path('storage/profiles/' . $post12->profile_photo_path);
    
            // Check if the image exists and then delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Remove the image file
            }
    
            // Delete the post from the database
            $post12->delete();
    
            return redirect()->route('dashboard');
        } else {
            return response()->json([
                'message' => "Post cannot be deleted"
            ]);
        }
    }
    
    public function editMyPost(Request $req){
        $post=post::find(id: $req->id);
        if(!empty($post)){
            return view('admin.edit',compact('post'));

        }else{
            return response()->json([
                "message"=>"no such post"

            ]);
        }
    }
    


    public function updatePost(Request $request)
    {
        // Validate the incoming request
        $validPost = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        // Check if validation fails
        if ($validPost->fails()) {
            return response()->json([
                "message" => "Please enter valid data",
                "errors" => $validPost->errors(),
            ], 400);
        }
    
        // Find the post by ID
        $post = Post::find($request->id);
    
        if (!$post) {
            return redirect()->route('posts.edit')->with('errors',"No post found");
        }
    
        // Update the post fields
        $post->title = $request->title;
        $post->description = $request->description;
    
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Store the image in the 'photos' directory in the 'public' disk
            $fileName = time() . "_" . $request->image->getClientOriginalName();
            $path =  $request->file('image')->storeAs('public/images', $fileName);
            $post->image = $fileName;
        }
    
        // Save the post
        $post->save();
    
        // Return success response
       return redirect()->route('dashboard');
    }
    public static function myFriends(){
        $fIds= new Collection();
        $ids=connection::where('id1',Auth::id())->orWhere('id2',Auth::id())->where('status','friend')->get();

        foreach($ids as $id){
            if($id->id1==Auth::id()){
                $fIds->push($id->id2);
            }else{
                $fIds->push($id->id1);
            }
            

        }
        return $fIds;
    }
    
}
