<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SettingResource::collection(Setting::all());
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
            'title' => 'required',
            'description' =>'required'
        ]);
        Setting::create([
            'title' => $request->title,
            'description' => $request->description
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
            'title' => 'required',
            'description' => 'required'
        ]);
        $setting=Setting::find($id);
        if($setting){
            $setting->update($request->all());
            return response()->json([
                'status' => 200,
                'message' =>"record updated successfully..."
            ]);
        }
        return response()->json([
            'status' => 201,
            'message' =>"record not available..."
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
        $setting=Setting::find($id);
        if(!$setting){
            return response()->json([
                'status'=>201,
                'message'=>"Record not available.."
            ]);
        }
        $setting->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Deleted successfully'
        ]);

    }
}
