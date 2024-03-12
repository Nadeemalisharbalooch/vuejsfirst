<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
class Categorycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category=category::create([
       'name'=>$request->categoryname,
        ]);
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

        $category=category::find($id);
        if($category){
            $category->update([
                'name'=>$request->categoryname,
            ]);
            return "data has successfully Updated";
        }
        else{
            return "No Found data again try";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $category=category::find($id);
        if($category){
            $category->delete();
            return "data has successfully deleted";
        }
        else{
            return "No Found data again try";
        }
    }
}
