<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
class searchcontroller extends Controller
{
   
    public function show(Request $request)
    {
        $keyword = $request->keyword;
    
        $posts = Post::where('title', 'like', '%' . $keyword . '%')->get();
    
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No records found']);
        }
    
        return response()->json(['posts' => $posts]);
    }

}
