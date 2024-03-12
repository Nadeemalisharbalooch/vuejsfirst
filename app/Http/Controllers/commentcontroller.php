<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;

class commentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //    $table->id();
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  

        return "data";
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
}
