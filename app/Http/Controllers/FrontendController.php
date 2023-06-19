<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\TopDestination;
use App\Models\PackageCategory;
use App\Models\PackagesInDemand;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\PackageListResource;
use App\Http\Resources\TopDestinationResource;
use App\Http\Resources\DestinationListResource;
use App\Http\Resources\PackageInDemandResource;
use App\Http\Resources\PackageCategoryListResource;

class FrontendController extends Controller
{
    function destination_list() {
        $destinations=Destination::with('packageCategories')->get();
        return response()->json([
            'status'=>200,
            'data'=>DestinationResource::collection($destinations)
        ]); 
    }
    function package_category_list(){
        $category=PackageCategory::get()->transform(function($cat){
            $data=[
                'id'=>$cat->id,
                'title'=>$cat->title,
            ];
            return $data;
        });
        return response()->json([
            'status'=>200,
            'data'=>$category
        ]); 
    }
    function package_category($destination_id){
        // dd($destination_id);
        $category=PackageCategory::whereHas('destinations',function($q)use($destination_id){
            $q->where('destinations.id',$destination_id);
        })->get()
        // ->transform(function($cat){
        //     $data=[
        //         'id'=>$cat->id,
        //         'name'=>$cat->name,
        //     ];
        //     return $data;
        // })
        ;
        return response()->json([
            'status'=>200,
            'data'=>PackageCategoryListResource::collection($category)
        ]);
    }

function destinationByCatagory($id) {
    
    $destinations=Destination::whereHas('packageCategories',function($q)use($id){
        $q->where('package_categories.id',$id);
    })->get();
    return response()->json([
        'status'=>200,
        'data'=>DestinationListResource::collection($destinations)
    ]);

}

public function createPackageInDemand(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        // Create a new record in the 'packages_in_demands' table
        $packageInDemand = PackagesInDemand::create([
            'package_id' => $validatedData['package_id'],
        ]);

        // Return a JSON response indicating success
        return response()->json([
            'status'=>200,
            'message' => 'Package in demand created successfully']);
    }
    function readPackageInDemand() {
        return PackageInDemandResource::collection(PackagesInDemand::paginate(2));
    }
    public function updatePackageInDemand(Request $request, $id)
    {
        $validatedData = $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);
        // Find the package in demand record by ID
        $packageInDemand = PackagesInDemand::findOrFail($id);

        // Validate the incoming request data
        

        // Update the package in demand record
        $packageInDemand->package_id = $validatedData['package_id'];
        $packageInDemand->save();

        // Return a JSON response indicating success
        return response()->json([
            'status'=>201,
            'message' => 'Package in demand updated successfully']);
    }
    public function deletePackageInDemand($id)
    {
        // Find the package in demand record by ID
        $packageInDemand = PackagesInDemand::findOrFail($id);

        // Delete the package in demand record
        $packageInDemand->delete();

        // Return a JSON response indicating success
        return response()->json([
            'status'=>201,
            'message' => 'Package in demand deleted successfully']);
    }


    public function createTopDestination(Request $request)
    {
        $validatedData = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
        ]);
        $topDestination = TopDestination::create([
            'destination_id' => $validatedData['destination_id'],
        ]);
        return response()->json([
            'status'=>200,
            'message' => 'Top Destination created successfully']);
    }
    function readTopDestination() {
        return TopDestinationResource::collection(TopDestination::paginate(2));
    }
    public function updateTopDestination(Request $request, $id)
    {
        $validatedData = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
        ]);
        $topDestination = TopDestination::findOrFail($id);
        $topDestination->destination_id = $validatedData['destination_id'];
        $topDestination->update();
        return response()->json([
            'status'=>201,
            'message' => 'updated successfully']);
    }
    public function deleteTopDestination($id)
    {
        $result = TopDestination::findOrFail($id);
        $result->delete();
        return response()->json([
            'status'=>201,
            'message' => 'deleted successfully']);
    }

    function packageByCatagory($id) {
    
        $packages=Package::whereHas('packageCategories',function($q)use($id){
            $q->where('package_categories.id',$id);
        })->get();
        
        return response()->json([
            'status'=>200,
            'data'=>PackageListResource::collection($packages)
        ]);
    
    }

}
