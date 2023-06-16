<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\PackageCategory;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\DestinationListResource;
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
}
