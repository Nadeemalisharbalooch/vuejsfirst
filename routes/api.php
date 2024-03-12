<?php

use Illuminate\Http\Request;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\postcontroller;
use App\Http\Controllers\controllercomment;
use App\Http\Controllers\searchcontroller;
use App\Http\Controllers\likecontroller; 
use App\Http\Controllers\countcontroller; 
use App\Http\Controllers\Categorycontroller;    
use App\Http\Controllers\Commentreply;  
use Illuminate\Support\Facades\Route;  
                                       
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
Route::post('register',[usercontroller::class,'store']);
Route::post('login',[usercontroller::class,'login'])->name('login');
Route::middleware('auth:api')->get('show',[usercontroller::class,'show']);
Route::middleware('auth:api')->delete('deleteuser/{id}',[usercontroller::class,'destroy']);
Route::middleware('auth:api')->post('updateuser/{id}',[usercontroller::class,'update']);
Route::middleware('auth:api')->delete('logout',[usercontroller::class,'logout']);
 
 // post controller  

 Route::post('post',[Postcontroller::class,'store']);  
 Route::post('createpost',[Postcontroller::class,'store'])->middleware('auth:api');
 Route::post('deletepost/{id}',[Postcontroller::class,'destroy'])->middleware('auth:api'); 
 Route::middleware('auth:api')->post('updatepost/{id}',[Postcontroller::class,'update']);
 Route::get('showpost',[Postcontroller::class,'show']);  
 Route::post('update/{id}',[Postcontroller::class,'update']);


 // post controller

 Route::delete('deletecomment/{id}',[commentcontroller::class,'destroy']);
 Route::post('deletepost/{id}',[Postcontroller::class,'destroy'])->middleware('auth:api'); 

 Route::middleware('auth:api')->post('updatepost/{id}',[Postcontroller::class,'update']);
 Route::get('showpost',[Postcontroller::class,'show']);  
 Route::post('update/{id}',[Postcontroller::class,'update']);   

//  search controller 
Route::get('search',[searchcontroller::class,'show'])->middleware('auth:api');  
Route::post('createcomment',[likecontroller::class,'store'])->middleware('auth:api'); 
Route::delete('deletecomment/{id}',[likecontroller::class,'destroy'])->middleware('auth:api'); 
Route::get('showcomment',[likecontroller::class,'show'])->middleware('auth:api');
Route::post('updatecomment/{id}',[likecontroller::class,'update'])->middleware('auth:api');
Route::get('showcomment',[likecontroller::class,'showcomment'])->middleware('auth:api');
Route::get('showsinglecomment/{id}',[likecontroller::class,'showsinglecomment'])->middleware('auth:api');

// count controller 

Route::get('countpost',[countcontroller::class,'countpost'])->middleware('auth:api');
Route::get('countcategory',[countcontroller::class,'countcategory'])->middleware('auth:api');
Route::get('counttag',[countcontroller::class,'counttag'])->middleware('auth:api');
Route::get('singlepost/{id}',[likecontroller::class,'singlepost'])->middleware('auth:api');


//  Category controller  

   Route::post('createcategory',[Categorycontroller::class,'store'])->middleware('auth:api');
   Route::delete('deletecategory/{id}',[Categorycontroller::class,'destroy'])->middleware('auth:api');
   Route::post('updatecategory/{id}',[Categorycontroller::class,'update'])->middleware('auth:api');


//    comment reply 
Route::post('commentreply',[Commentreply::class,'store'])->middleware('auth:api');