<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\like;
use App\Models\post;
use App\Models\profileModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;


class postController extends Controller
{
    public function createMyPost(Request $request)
    {


        $validatePost = validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'description' => 'required',
                'image' => 'required|image'
            ],
        );

        if ($validatePost->fails()) {
            echo $validatePost->errors();

        } else {


            if ($request->hasFile('image')) {
                // Generate a unique filename with timestamp and the original file's extension
                $fileName = time() . "_" . $request->image->getClientOriginalName();

                // Store the file in the public/images directory
                $filePath = $request->file('image')->storeAs('public/images', $fileName);

                // Save the post with the stored file path
                $postByUser = post::create([
                    'user_id' => Auth::user()->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $fileName,  // Store only the file name in the database
                ]);

                return redirect()->route('dashboard');
            } else {
                // return back()->with('error', 'Image file is required.');
                echo "file not found";
            }




        }
    }

    public function increaseLike(Request $req)
    {
        // Retrieve the first like entry for the given post_id
        $getInfo = like::where('post_id', $req->id)->first();
        // If no like record exists for this post, create one
        if (is_null($getInfo)) {
            like::create([
                'post_id' => $req->id,
                'user_id' => Auth::user()->id,
                'like' => 1,
            ]);
            echo "You are first to send like to this post";
           // return the like count of 1
        } else {
            $alreadyLiked = like::where('user_id', Auth::id())
                ->where('post_id', $req->id)
                ->first();
            // If the user has already liked the post, prevent double-liking
            if ($alreadyLiked) {
               echo "you have already liked this post";
            } else {
                like::create([
                    'post_id' => $req->id,
                    'user_id' => Auth::user()->id,
                    'like' => 1,
                    
                ]);
                echo "Yep done";
            }
            
        }
    }

    public function displayLikes(Request $request)
    {
        // Fetch the user's like count based on the passed user ID
        $user = like::where('post_id',$request->id)->get('like');
        
        if ($user) {
            $c=0;
            foreach($user as $man){
                $c++;

            }
           echo $c; // Return the like count
        }else{
            echo 0;
        }
        
        
    }
    

    public function increaseComment(Request $req)
    {
        comment::create([
            'post_id' => $req->id,
            'user_id' => Auth::user()->id,
            'comment' => $req->comment,
        ]);
        return redirect()->route('dashboard');
    }
    public function displayComments(Request $request)
    {
        // Fetch comments along with user data
        $comments = comment::with('user.profile')
            ->where('post_id', $request->id)
            ->get(['comment', 'user_id']); 
            
           
            // Fetch only necessary fields
    
        // Transform the comments to include userName
        $commentsWithUserNames = $comments->map(function($comment) {
            return [
                'comment' => $comment->comment,
                'userName' => $comment->user->name,
                'photo' =>$comment->user->profile->profile_photo_path,                
            ];
        });
    
        // Return the comments with userName as a JSON response
        return response()->json($commentsWithUserNames);
    }
  
    public static function postEditor($post_id){
        $id=post::where('id',$post_id)->first();
        if(Auth::user()->userType=='admin'||Auth::id()==$id->user_id){
            return 1;
        }else{
            return 0;
        }        
    }
        

}

