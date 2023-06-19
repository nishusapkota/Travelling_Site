<?php

namespace App\Http\Controllers;
use App\Http\Resources\DestinationResource;
use App\Models\Destination;
use App\Models\PackageCategory;
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
    public function store(Request $request,Destination $destination)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'short_description'=>'required',
            'description'=>'required',
            'package_categories_id'=>'nullable|array',      
            'package_categories_id.*'=>'exists:package_categories,id',
            
        ]);

        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('destination_image'),$image_name);

       $result= $destination->create([
        'title'=>$request->title,
            'image'=>'destination_image/'.$image_name,
            'short_description'=>$request->short_description,
            'description'=>$request->description
        ]);
        $result->packageCategories()->attach($request->package_categories_id);

       // $packageCategoryid=[1,2];
       // $destination->packageCategories()->attach($request->package_categories_id);

        if($result){
            return response()->json([
                'status'=>200,
                'message'=>'Destination created successfully..'
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
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'short_description'=>'required',
            'description'=>'required',
            'package_categories_id'=>'nullable|array',      
            'package_categories_id.*'=>'exists:package_categories,id',
        ]);
       
        $destination=Destination::find($id);

        if(!$destination){
            return response()->json([
                'status'=>'201',
                'message'=>"Record not available.."
            ]);
        }
       $destination->packageCategories()->sync($request->package_categories_id);
        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('destination_image'),$image_name);
       
        $result=$destination->update([
            'title'=>$request->title,
            'image'=>'destination_image/'.$image_name,
            'short_description'=>$request->short_description,
            'description'=>$request->description 
        ]);
        if($result){
            return response()->json([
                'status'=>'200',
                'message'=>'updated successfully....'
            ]);
        }
        return response()->json([
            'status'=>'201',
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
