<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;

class PackageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PackageCategory::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,PackageCategory $packageCategory )
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'description'=>'required',
            'destination_id'=>'required'
        ]);

        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('category_image'),$image_name);
        
       $result= $packageCategory->create([
        'title'=>$request->title,
            'image'=>$image_name,
            'description'=>$request->description,
            'destination_id'=>$request->destination_id
        ]);
       
        if($result){
            return response()->json([
                'message'=>'Category created successfully..'
            ]);
        }
        return response()->json([
            'message'=>'Failed to create category..'
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
        $packageCategory=PackageCategory::find($id);
       
        if($packageCategory){
            return $packageCategory;
        }
        return response()->json([
            'message'=>'Result Not Found...'
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
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'description'=>'required',
            'destination_id'=>'required'
        ]);
        $packageCategory=PackageCategory::find($id);

        if(!$packageCategory){
            return response()->json([
                'message'=>"Record not available.."
            ]);
        }
        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('category_image'),$image_name);
        $result=$packageCategory->update([
            'title'=>$request->title,
            'image'=>$image_name,
            'description'=>$request->description,
            'destination_id'=>$request->destination_id
        ]);
        if($result){
            return response()->json([
                'message'=>'updated successfully....'
            ]);
        }
        return response()->json([
            'message'=>'Fail to update ....'
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
        $result=PackageCategory::destroy($id);
        if($result){
            return response()->json([
                'message'=>'Deleted Successfully'
            ]);
        return response()->json([
            'message'=>'Failed to delete'
        ]);
        }
    }
}
