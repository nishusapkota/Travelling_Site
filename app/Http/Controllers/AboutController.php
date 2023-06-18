<?php

namespace App\Http\Controllers;

use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about=About::all();
        return response()->json([
            'status'=>200,
            'data'=>AboutResource::collection($about)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,About $about)
    {
        $request->validate([
            'description'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'img_title'=>'required',
            'img_body'=>'required',
            'icon'=>'required|image|mimes:png,jpg,jpeg',
            'client_count'=>'required',
            'client_desc'=>'required'
        ]);

        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('about_image'),$image_name);
        $icon_name=time().".".$request->file('icon')->getClientOriginalExtension();
        $request->file('icon')->move(public_path('icon_image'),$icon_name);
       
       $result= $about->create([
            'description'=>$request->description,
            'image'=>'about_image/'.$image_name,
            'img_title'=>$request->img_title,
            'img_body'=>$request->img_body,
            'icon'=>'icon_image/'.$icon_name,
            'client_count'=>$request->client_count,
            'client_desc'=>$request->client_desc
        ]);
       
        if($result){
            return response()->json([
                'status'=>200,
                'message'=>'About data created successfully..'
            ]);
        }
        return response()->json([
            'status'=>201,
            'message'=>'Failed to create about content..'
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
        $about=About::find($id);
        if($about){
            return $about;
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
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'img_title'=>'required',
            'img_body'=>'required',
            'icon'=>'required|image|mimes:png,jpg,jpeg',
            'client_count'=>'required',
            'client_desc'=>'required'
    ]);
    $about=About::find($id);
    if(!$about){
        return response()->json([
            'status'=>201,
            'message'=>'Content not available..'
        ]);
    }
    $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('about_image'),$image_name);
        $icon_name=time().".".$request->file('icon')->getClientOriginalExtension();
        $request->file('icon')->move(public_path('icon_image'),$icon_name);
       
       $result= $about->update([
            'description'=>$request->description,
            'image'=>'about_image/'.$image_name,
            'img_title'=>$request->img_title,
            'img_body'=>$request->img_body,
            'icon'=>'icon_image/'.$icon_name,
            'client_count'=>$request->client_count,
            'client_desc'=>$request->client_desc
        ]);

    
    if($result){
        return response()->json([
            'status'=>200,
            'message'=>'Updated successfully....'
        ]);
    }
    return response()->json([
        'status'=>201,
        'message'=>'Fail to update....'
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
        $result=About::destroy($id);
        if($result){
          return response()->json([
            'status'=>200,
              'message'=>'Deleted Successfully..'
          ]);
      return response()->json([
        'status'=>201,
          'message'=>'Failed to delete..'
      ]);
      }   
    }
}
