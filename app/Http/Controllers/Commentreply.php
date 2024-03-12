<?php

namespace App\Http\Controllers;
use App\Models\comment_reply;
use Illuminate\Http\Request;

class Commentreply extends Controller
{
    public function store(request $request){
        $loggedInUserId = auth('api')->user()->id;
    $comment_replies=comment_reply::create([
       'comment_id'=>1,
       'user_id'=>$loggedInUserId,
       'comment'=>$request->commentreply,

    ]);
    return "comment reply successfully ";
       
    }
}
