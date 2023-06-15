<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Destination::with('packageCategories')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Destination $destination)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'description'=>'required'
        ]);

        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('destination_image'),$image_name);

       $result= $destination->create([
        'title'=>$request->title,
            'image'=>$image_name,
            'description'=>$request->description
        ]);
       // $packageCategoryid=[1,2];
        //$destination->packageCategories()->attach($packageCategoryid,['destinations_id' => $result->id]);

        if($result){
            return response()->json([
                'message'=>'Destination created successfully..'
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
        $destination=Destination::find($id);
       
        if($destination){
            return $destination;
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
            'description'=>'required'
        ]);
        $packageCategories  = [4,5];
        $destination=Destination::find($id);

        if(!$destination){
            return response()->json([
                'message'=>"Record not available.."
            ]);
        }
        $destination->packageCategories()->sync($packageCategories);
        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('destination_image'),$image_name);
        $result=$destination->update([
            'title'=>$request->title,
            'image'=>$image_name,
            'description'=>$request->description 
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
        $result = Destination::find($id);
        $result->packageCategories()->detach();
        $result=Destination::destroy($id);

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
