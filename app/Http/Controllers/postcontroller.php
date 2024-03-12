<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class postcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function comment(){
        return "yes i am comment route";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    

        $login_user_id =  auth('api')->user()->id;
       
        // Validate title, cat_id, and tags fields
        $request->validate([
            'title' => 'required|string',
            'cat_id' => 'required|integer',
            'description' => 'required|string',
            'tags' => 'array',
       
        ]); 
        if ($request->hasFile('file')) {
            try { 
                $file = $request->file('file');
                $fileName = rand(100, 10000) . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads', $fileName, 'public');
                $post = Post::create([ 
                    'user_id' => $login_user_id,
                    'title' => $request->title,
                    'category_id' =>1,
                    'description' => $request->description,
                    'image' => $fileName,
                ]);

                foreach ($request->tags as $tag) {
                    $post->tags()->attach($tag);
                }  
                // Optionally, you can return the created post in the response
                return response()->json(['message' => 'Post created successfully', 'post' => $post], 200);
            } catch (\Exception $e) {
                // Handle any exceptions that occurred during file upload or database insertion
                return response()->json(['message' => 'Error occurred while processing the request'], 500);
            }
        } else {
            return response()->json(['message' => 'File not found in the request'], 400);
        }
    }
      
    /**
     * Display the specified resource.
     */

  

    public function show()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $posts = Post::all();
        $responseData = [
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]; 
        return response()->json($responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {  
        $login_user_id = auth('api')->user()->id;
        // Validate title, cat_id, and tags fields
        $request->validate([
            'title' => 'required|string',
            'cat_id' => 'required|integer',
            'description' => 'required|string',
            'tags' => 'array',
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        if ($post->user_id !== $login_user_id) {
            return response()->json(['error' => 'Unauthorized to update this post'], 403);
        }

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $fileName = rand(100, 10000) . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads', $fileName, 'public');
                $post->update([
                    'title' => $request->title,
                    'category_id' => $request->cat_id,
                    'description' => $request->description,
                    'image' => $fileName,
                ]);
            } catch (\Exception $e) {
                // Handle any exceptions that occurred during file upload or database update
                return response()->json(['message' => 'Error occurred while processing the request'], 500);
            }
        } else {
            // If no new file is provided, update other fields
            $post->update([
                'title' => $request->title,
                'category_id' => $request->cat_id,
                'description' => $request->description,
            ]);
            }
        // Sync tags if tags are provided in the request
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        // Optionally, you can return the updated post in the response
        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Detach all tags related to the post
        $post->tags()->detach(); 
        // Delete the post
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}    