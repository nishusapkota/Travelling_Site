<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoverphotoResource;
use App\Models\CoverPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CoverPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CoverphotoResource::collection(CoverPhoto::all());
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
            'cover_image' => 'required|image',
            'destination_id' => 'required|exists:destinations,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $coverPhoto = new CoverPhoto();
        $coverImage = $request->file('cover_image');
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('cover_image'),$coverImageName);
            $coverPhoto->cover_image = $coverImageName;
        $coverPhoto->create([
            'title'=>$request->input('title'),
            'cover_image'=>'cover_image/'.$coverImageName,
            'destination_id'=>$request->input('destination_id')
        ]);
        return response()->json(['message' => 'Cover photo created successfully'], 201);
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
        'cover_image' => 'required|image',
        'destination_id' => 'required|exists:destinations,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $coverPhoto = CoverPhoto::find($id);

    if (!$coverPhoto) {
        return response()->json(['error' => 'Cover photo not found'], 404);
    }
    $coverImage = $request->file('cover_image');
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('cover_image'),$coverImageName);
           
$coverPhoto->update([
    $coverPhoto->title => $request->input('title'),
    $coverPhoto->cover_image = $coverImageName,
    $coverPhoto->destination_id= $request->input('destination_id')
]);
return response()->json(['message' => 'Cover photo updated successfully'], 200);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $coverPhoto = CoverPhoto::find($id);

    if (!$coverPhoto) {
        return response()->json(['error' => 'Cover photo not found'], 404);
    }

    $coverPhoto->delete();

    return response()->json(['message' => 'Cover photo deleted successfully'], 200);
}

}
