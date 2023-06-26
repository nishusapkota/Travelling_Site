<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
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
    public function store(StoreBlogRequest $request)
    {
        $image_name= time().".".$request->file('image')->getClientOriginalExtension();
       $request->file('image')->move(public_path('blog_image'),$image_name);
       Blog::create([
       // 'description' => $request->description,
        'image' => 'blog_image/'.$image_name,
        'title' => $request->title,
        'body' => $request->body
       ]);
        return response()->json([
            'status'=>200,
            'message'=>'Blog created successfully..'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogRequest $request, $id)
    {
        $blog=Blog::find($id);
        if(!$blog){
            return response()->json([
                'status'=>201,
                'message'=>'Blog not available..'
            ]);
        }
        if($request->hasFile('image')){
            $image_path=public_path($blog->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $image_name= time().".".$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('blog_image'),$image_name);    
        }
        
        $result=$blog->update([
           // 'description'=>$request->description,
            'title'=>$request->title,
            'image'=>'blog_image/'.$image_name,
            'body'=>$request->body
        ]);
        return response()->json([
            'status'=>200,
            'message'=>'blog updated successfully....'
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
      $blog=Blog::find($id);
      if(!$blog){
        return response()->json([
            'status'=> 201,
            'message'=>"record not found.."
        ]);
      }
      $image_path=public_path($blog->image);
      if(file_exists($image_path)){
        unlink($image_path);
      }
      $blog->delete();
      return response()->json([
        'status' => 200,
        'message' => 'Blog deleted successfully...'
      ]);
      
    }
}
