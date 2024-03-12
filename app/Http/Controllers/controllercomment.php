<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;

class controllercomment extends Controller
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
}
