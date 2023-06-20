<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
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
        $package=Package::with('destination')->get();
        // dd($package);
        return response()->json([
            'status'=>200,
            'data'=>PackageResource::collection($package)
        ]);
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
            'location'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'price'=>'required',
            'overview'=>'required',
            'duration'=>'required',
            'destinations_id'=>'required',
            'package_categories_id'=>'required|array',
            'package_categories_id.*'=>'required|exists:package_categories,id'
        ]);

        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('package_image'),$image_name);
        
       $result=$package->create([
        'location'=>$request->location,
        'image'=>'package_image/'.$image_name,
        'price'=>$request->price,
        'overview'=>$request->overview,
        'duration'=>$request->duration,
        'destinations_id'=>$request->destinations_id
        ]);
       $result->packageCategories()->attach($request->package_categories_id);
        if($result){
            return response()->json([
                'status'=>200,
                'message'=>'Package created successfully..'
            ]);
        }
        return response()->json([
            'status'=>201,
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
        $package=Package::with('packageCategories')->find($id);
       
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
            'location'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'price'=>'required',
            'overview'=>'required',
            'duration'=>'required',
            'destinations_id'=>'required',
            'package_categories_id'=>'required|array',
            'package_categories_id.*'=>'required|exists:package_categories,id'
        ]);

        $package=Package::find($id);
       
        if($package){
            $image_name=time().".".$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('package_image'),$image_name);
            $package->packageCategories()->sync($request->package_categories_id);
           $result=$package->update([
            'location'=>$request->location,
            'image'=>'package_image'.$image_name,
            'price'=>$request->price,
            'overview'=>$request->overview,
            'duration'=>$request->duration,
            'destinations_id'=>$request->destinations_id
            ]);
           
            if($result){
                return response()->json([
                    'status'=>200,
                    'message'=>'Package updated successfully..'
                ]);
            }
            return response()->json([
                'status'=>201,
                'message'=>'Failed to update..'
            ]);
           
        }
        return response()->json([
            'status'=>201,
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
        $package=Package::find($id);
        $package->packageCategories()->detach();
        $result=$package->delete();
        if($result){
            return response()->json([
                'status'=>200,
                'message'=>'Deleted Successfully'
            ]);
        return response()->json([
            'status'=>201,
            'message'=>'Failed to delete'
        ]);
        }
    }
}
