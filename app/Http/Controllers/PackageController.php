<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Package::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Package $package)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'price'=>'required',
            'overview'=>'required',
            'duration'=>'required',
            'package_category_id'=>'required'
        ]);

        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('package_image'),$image_name);
        
       $result=$package->create([
        'title'=>$request->title,
        'image'=>$image_name,
        'price'=>$request->price,
        'overview'=>$request->overview,
        'duration'=>$request->duration,
        'package_category_id'=>$request->package_category_id
        ]);
       
        if($result){
            return response()->json([
                'message'=>'Package created successfully..'
            ]);
        }
        return response()->json([
            'message'=>'Failed to create destination..'
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
        $package=Package::find($id);
       
        if($package){
            return $package;
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
            'price'=>'required',
            'overview'=>'required',
            'duration'=>'required',
            'package_category_id'=>'required'
        ]);

        $package=Package::find($id);
       
        if($package){
            $image_name=time().".".$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('package_image'),$image_name);
            
           $result=$package->update([
            'title'=>$request->title,
            'image'=>$image_name,
            'price'=>$request->price,
            'overview'=>$request->overview,
            'duration'=>$request->duration,
            'package_category_id'=>$request->package_category_id
            ]);
           
            if($result){
                return response()->json([
                    'message'=>'Package updated successfully..'
                ]);
            }
            return response()->json([
                'message'=>'Failed to update..'
            ]);
           
        }
        return response()->json([
            'message'=>'Result Not Found...'
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
        $result=Package::destroy($id);
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
