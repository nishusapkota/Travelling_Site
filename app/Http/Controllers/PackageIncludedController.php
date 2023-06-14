<?php

namespace App\Http\Controllers;

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
        return PackageIncluded::all();
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
                'message'=>'Record created successfully..'
            ]);
        }
        return response()->json([
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
                    'message'=>'Record updated successfully..'
                ]);
            }
             return response()->json([
               'message'=>'Failed to update..'
            ]);
        }
        return response()->json([
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
                'message'=>'Deleted Successfully'
            ]);
        return response()->json([
            'message'=>'Failed to delete'
        ]);
        }
    }
}
