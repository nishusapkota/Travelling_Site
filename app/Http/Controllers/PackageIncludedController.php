<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageIncludedResource;
use App\Models\PackageIncluded;
use Illuminate\Http\Request;

class PackageIncludedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packageinclude=PackageIncluded::all();
        return PackageIncludedResource::collection($packageinclude);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,PackageIncluded $packageinclude)
    {
        $request->validate([
            'package_id'=>'required',
            'description'=>'required'
        ]);

       $result= $packageinclude->create([
            'package_id'=>$request->package_id,
            'description'=>$request->description
        ]);
        if($result){
            return response()->json([
                'status'=>200,
                'message'=>'Record created successfully..'
            ]);
        }
        return response()->json([
            'status'=>201,
            'message'=>'Failed to create..'
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
        $package=PackageIncluded::find($id);
       
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
            'package_id'=>'required',
            'description'=>'required'
        ]);

        $package=PackageIncluded::find($id);
        if($package){
            $result= $package->update([
                'package_id'=>$request->package_id,
                'description'=>$request->description
            ]);
            if($result){
                return response()->json([
                    'status'=>200,
                    'message'=>'Record updated successfully..'
                ]);
            }
             return response()->json([
                'status'=>201,
               'message'=>'Failed to update..'
            ]);
        }
        return response()->json([
            'status'=>201,
            'message'=>'Record not available'
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
        $result=PackageIncluded::destroy($id);
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
