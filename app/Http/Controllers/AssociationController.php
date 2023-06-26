<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (Association::all());   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=>'required|image'
        ]);
        $image_name = time().".".$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('association_image'),$image_name);
        Association::create([
            'image' => 'association_image/'.$image_name
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Record created successfully....' 
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
        //
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
            'image' => 'required'
        ]);
        $association = Association::find($id);
        if(!$association){
            return response()->json([
                'status' => 201,
                'message' => 'Record not available...'
            ]);
        }
        unlink(public_path($association->image));
        $image_name = time().".".$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('association_image'),$image_name);
       $association->update(['image' => 'association_image/'.$image_name]);
        return response()->json([
            'status' => 200,
            'message' => 'Record updated successfully....' 
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
        $association = Association::find($id);
        if(!$association){
            return response()->json([
                'status' => 201,
                'message' => 'Record not available...'
            ]);
        }
        unlink(public_path($association->image));
        $association->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Record deleted successfully....' 
        ]);
        
    }
}
