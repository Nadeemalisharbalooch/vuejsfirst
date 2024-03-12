<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class likecontroller extends Controller
{
    public function store(Request $request)
    {  

       
        $login_user_id = auth('api')->user()->id;
    // Validate the required fields
       $request->validate([
        'post_id' => 'required', // Add other validation rules for other fields if needed.
        'comment' => 'required',
    ]);

// Create the comment if the user is logged in.
   
    $comment = comment::create([
        'user_id' => $login_user_id,
        'post_id' => $request->post_id,
        'comment' => $request->comment,
    ]);
    return response([
        'message' => 'comment successfully created.',
    ], 200);

    }
  public function show(){

    return "show comment";
  }



    public function destroy(string $id)
    {
        $user=comment::find($id);
        if($user){
          $user->delete();
          return "data deleted successfully";
        }
        else{
         return response([
          'The data you are trying to delete does not exist'
         ]);
        }
    }

    public function update(string $id)
    {
       
        $comment = comment::find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Order not found.');
        }   

        if ($comment->status == 1) {
            comment::where('id', $id)->update(['status' => 0]);
        } else {
            $order->status = 1;
            comment::where('id', $id)->update(['status' => 1]);
        }
        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    public function showcomment()
    {
        return comment::all();
    }

    public function showsinglecomment(string $id)
    {
        
        $comment = comment::where('post_id', '=', $id)->get();
        return $comment; 
    } 
     public function singlepost(string $id){
    
        $post = post::with('comments')->where('id', '=', $id)->first();
      
        return response([
            'post'=>$post
        ]);
    }
}

