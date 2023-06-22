<?php

namespace App\Http\Controllers;
use App\Models\CoverPhoto;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\PackageCategory;
use App\Http\Resources\DestinationResource;
use App\Http\Requests\DestinationStoreRequest;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinations=Destination::with('packageCategories')->get();
        return response()->json([
            'status'=>200,
            'data'=>DestinationResource::collection($destinations)
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Destination $destination,DestinationStoreRequest $req)
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $destination = Destination::find($id);
    return response()->json([
        'status' => 200,
        'data' => DestinationResource::collection([$destination])
        ->map(function ($resource) {
            return $resource->toArray(request());
        }),
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
    $destination = Destination::find($id);

    if (!$destination) {
        return response()->json([
            'status' => 404,
            'message' => 'Destination not found.',
        ]);
    }

    // Update the destination details
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

    
    

    // Update the cover images
    if ($request->hasFile('cover_image')) {
        $coverImages = $request->file('cover_image');
        $locations = $request->input('location');


        // Store the updated cover images
        foreach ($coverImages as $key => $coverImage) {
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('cover_image'), $coverImageName);
            $destination->coverPhotos->update([
                'location' => $locations[$key],
                'cover_image' => 'cover_image/' . $coverImageName,
                'destination_id' => $destination->id,
            ]);
        }
    }

    return response()->json([
        'status' => 200,
        'message' => 'Destination updated successfully.',
        'destination' => $destination,
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
                'status'=>'200',
                'message'=>'Deleted Successfully'
            ]);
        return response()->json([
            'status'=>'201',
            'message'=>'Failed to delete'
        ]);
        }
    }
}
