<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
class countcontroller extends Controller
{
    public function countpost()
    {
        $postCount = Post::count();

        return response([
            'message' => $postCount,
        ], 201);
    }
    public function countcategory()
    {
        $countcategory = category::count();
         return response([
            'message' => $countcategory,
        ], 201);
    }
    public function counttag()
    {
        $counttag = tag::count();
    
        return response([
            'message' => $counttag,
        ], 201);
    }
}
