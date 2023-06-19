<?php

namespace App\Http\Controllers;

use App\Http\Resources\PortraitImageResource;
use Illuminate\Http\Request;
use App\Models\PortraitImage;
use Illuminate\Support\Facades\Validator;

class PortraitImgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PortraitImageResource::collection(PortraitImage::paginate(4));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
            //dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            
            'destination_id' => 'required|exists:destinations,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $Photo = new PortraitImage();
        $image = $request->file('image');
        $ImageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('portrait_image'), $ImageName);

        $Photo->create([
            'title' => $request->input('title'),
            'image' => 'portrait_image/' . $ImageName,
            
            'destination_id' => $request->input('destination_id')
        ]);
        return response()->json(['message' => 'portrait photo created successfully'], 201);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
           
            'destination_id' => 'required|exists:destinations,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $Photo = PortraitImage::find($id);

        if (!$Photo) {
            return response()->json(['error' => 'photo not found'], 404);
        }
       
        $image = $request->file('image');
        $ImageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('portrait_image'), $ImageName);

        $Photo->update([
            'title' => $request->input('title'),
            'image' => 'portrait_image/' . $ImageName,
           
            'destination_id' => $request->input('destination_id')
        ]);
        return response()->json(['message' => 'photo updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Photo = PortraitImage::find($id);

    if (!$Photo) {
        return response()->json(['error' => 'photo not found'], 404);
    }

    $Photo->delete();

    return response()->json(['message' => 'photo deleted successfully'], 200);
    }
}
