<?php

namespace App\Http\Controllers;

use App\Models\CoverPhoto;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\PackageCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CoverphotoResource;
use App\Http\Resources\DestinationResource;
use App\Http\Requests\DestinationStoreRequest;
use App\Http\Requests\DestinationUpdateRequest;

class DestinationController extends Controller
{

    public function index()
    {
        $destinations = Destination::with('packageCategories')->get();
        return response()->json([
            'status' => 200,
            'data' => DestinationResource::collection($destinations)
        ]);
    }


    public function store(DestinationStoreRequest $request, Destination $destination)
    {
        // $req->validated();
        $image_name = time() . "." . $request->file('portrait_image')->getClientOriginalExtension();
        $request->file('portrait_image')->move(public_path('portrait_image'), $image_name);

        $result = $destination->create([
            'destination' => $request->destination,
            'portrait_image' => 'portrait_image/' . $image_name,
            'short_description' => $request->short_description ?: null,
            'description' => $request->description
        ]);
        $result->packageCategories()->attach($request->package_categories_id);

        foreach ($request->file('cover_image') as $key => $coverImage) {
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('cover_image'), $coverImageName);
            CoverPhoto::create([
                'location' => $request->location[$key],
                'cover_image' => 'cover_image/' . $coverImageName,
                'destination_id' => $result->id
            ]);
        }

        if ($result) {
            return response()->json([
                'status' => 200,
                'message' => 'Destination created successfully.'
            ]);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Failed to create destination.'
        ]);
    }
    public function update(DestinationUpdateRequest $request, $id)
    {
        $destination = Destination::find($id);
        if (!$destination) {
            return response()->json([
                'status' => 404,
                'message' => 'Destination not found.',
            ]);
        }
        if ($request->hasFile('portrait_image')) {
            $imagePath = public_path($destination->portrait_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image_name = time() . '.' . $request->file('portrait_image')->getClientOriginalExtension();
            $request->file('portrait_image')->move(public_path('portrait_image'), $image_name);
        }
        $destination->update([
            'destination' => $request->destination,
            'short_description' => $request->short_description ?: null,
            'description' => $request->description,
            'portrait_image' => 'portrait_image/' . $image_name,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Destination updated successfully.',
            'destination' => $destination,
        ]);
    }
    public function destroy($id)
    {
        $result = Destination::find($id);
        $result->packageCategories()->detach();
        $result = Destination::destroy($id);

        if ($result) {
            return response()->json([
                'status' => '200',
                'message' => 'Deleted Successfully'
            ]);
            return response()->json([
                'status' => '201',
                'message' => 'Failed to delete'
            ]);
        }
    }

    public function indexCover($id)
    {
       // dd($id);
       $coverPhotos = DB::table('cover_photos')
        ->where('destination_id', $id)
        ->get();

    return CoverphotoResource::collection($coverPhotos);
       // CoverPhoto::where('destination_id',$id)->get();
     
    }

    public function updateCover(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'location' => 'required',
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
    if ($request->hasFile('cover_image')) {
        $imagePath = public_path($coverPhoto->cover_image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $coverImage = $request->file('cover_image');
        $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
        $coverImage->move(public_path('cover_image'),$coverImageName);
    }                     
$coverPhoto->update([
    'location' => $request->input('location'),
    'cover_image' => 'cover_image/'.$coverImageName,
    'destination_id' => $request->input('destination_id')
]);
return response()->json(['message' => 'Cover photo updated successfully'], 200);
}
}
