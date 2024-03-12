<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Rules\UniqueEmail;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user = user::create([    
            'name' =>'nadeem',
            'email' =>'pa@mail.com',
            'password' =>'123',  
        ]);
        $token = $user->createToken('Token Name')->accessToken;

        return response([
            'token' => $token,
        ], 201);
    }

    public function login(request $request){
       
        $user=user::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
      
            return response([
             'message'=>'the provided creadentials are incorrect.'
            ],401);
        }
        else{
           
            $token = $user->createToken('Token Name')->accessToken;
            return response([
                'token' => $token,
                'user'=>$user
            ], 201);
        }
        }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|confirmed ',
                    ]);
         $user=user::where('email',$request->email)->first(); 
    if(!$user){
        $user = user::create([    
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>$request->password,  
        ]);
        $token = $user->createToken('Token Name')->accessToken;
        return response([
            'token' => $token,
        ], 201); 
    }
    else{
        return response([
          'message'=>'Sorry, but this email already exists in our records.'
           ],401);
    }
}
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $loggedInUserId = auth('api')->user()->id;
     
        $users = User::where('id', '<>', $loggedInUserId)->get();
        

        return response([
            'user'=>$users
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
       return "suceesfully logout";
    
    }  


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $request->validate([
            'name'=>'required',
            'email'=>'required',
                    ]);

        $rowsAffected = DB::table('users')
        ->where('id', $id)
        ->update([
         'name' =>$request->name,
         'email' =>$request->email,
    ]);  
    if ($rowsAffected === 0) {
    return "Record not found"; // Handle the case when the record with the given $id is not found.
    }
    return "Data has been successfully updated";
        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 
        $user=user::find($id);
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

