<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\DestinationPackageCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PackageCategory::with('destinations')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,PackageCategory $packageCategory )
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg',
            'description'=>'required',
            'destinations_id'=>'required|array',      
            'destinations_id.*'=>'required|exists:destinations,id',      
            
        ]);
        // dd($request->all());
        // DB::beginTransaction();
        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('category_image'),$image_name);
        
       $result= $packageCategory->create([
        'title'=>$request->title,
            'image'=>$image_name,
            'description'=>$request->description,
           
        ]);
        // dd($result);
        // $destinationid = collect(Destination::all())->pluck('id')->toArray();
        $result->destinations()->attach($request->destinations_id);
        // dd($result->destinations());
        if($result){
            return response()->json([
                'message'=>'Category created successfully..'
            ]);
        }
        return response()->json([
            'message'=>'Failed to create category..'
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
        $packageCategory=PackageCategory::with('destinations')->find($id);
        
        if($packageCategory){
            return $packageCategory;
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
            'description'=>'required',
            'destinations_id'=>'required|array',
            'destinations_id.*'=>'required|exists:destinations,id',      

        ]);
        $packageCategory=PackageCategory::find($id);

        if(!$packageCategory){
            return response()->json([
                'message'=>"Record not available.."
            ]);
        }
        $image_name=time().".".$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('category_image'),$image_name);
        $packageCategory->destinations()->sync($request->destinations_id);

        $result=$packageCategory->update([
            'title'=>$request->title,
            'image'=>$image_name,
            'description'=>$request->description,
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
        $record=PackageCategory::find($id);
        $record->destinations()->detach();
        $result=$record->delete();

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
