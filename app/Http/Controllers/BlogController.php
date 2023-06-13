<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Blog::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'description'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif',
            'title'=>'required',
            'body'=>'required'
        ]);

        $blog= new Blog();
        $blog->description=$request->description;

        $image_name= time().".".$request->file('image')->getClientOriginalExtension();
       $path=$request->file('image')->move(public_path('blog_image'),$image_name);
        $blog->image=$image_name;

        $blog->title=$request->title;
        $blog->body=$request->body;

        $blog->save();

        return response()->json([
            'message'=>'Blog created successfully..'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog=Blog::find($id);
        if($blog){
            return $blog;
        }
        return response()->json([
            'message'=>'record isnot available...'
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $request->validate([
            'description'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif',
            'title'=>'required',
            'body'=>'required'
        ]);
        $blog=Blog::find($id);
        if(!$blog){
            return response()->json([
                'message'=>'Blog not available..'
            ]);
        }
        $image_name= time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('blog_image'),$image_name);

        $result=$blog->update([
            'description'=>$request->description,
            'title'=>$request->title,
            'image'=>$image_name,
            'body'=>$request->body
        ]);
        if($result){
            return response()->json([
                'message'=>'blog updated successfully....'
            ]);
        }
        return response()->json([
            'message'=>'Fail to update blog....'
        ]);


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $result=Blog::destroy($id);
      if($result){
        return response()->json([
            'message'=>'Blog Deleted Successfully'
        ]);
    return response()->json([
        'message'=>'Failed to delete blog'
    ]);
    }
    }
}
