<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\PackageCategory;
use Illuminate\Support\Facades\DB;
use App\Models\DestinationPackageCategory;

use App\Http\Requests\StorePackageCategory;
use App\Http\Resources\PackageCategoryResource;
use App\Http\Requests\StorePackageCategoryRequest;
use App\Http\Requests\StorePackageRequest;

class PackageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packageCategory = PackageCategory::with('destinations')->get();
        return response()->json([
            'status' => 200,
            'data' => PackageCategoryResource::collection($packageCategory)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageCategoryRequest $request)
    {
        // dd($request->all());
        // DB::beginTransaction();
        $image_name = time() . "." . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('category_image'), $image_name);

        $result = PackageCategory::create([
            'title' => $request->title,
            'image' => 'category_image/' . $image_name,
            'description' => $request->description,
            'short_description' => $request->short_description ?: null
        ]);
        // dd($result);
        // $destinationid = collect(Destination::all())->pluck('id')->toArray();
        $result->destinations()->attach($request->destinations_id);
        // dd($result->destinations());
        return response()->json([
            'status' => 200,
            'message' => 'Category created successfully..'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePackageCategoryRequest $request, $id)
    {
        $packageCategory = PackageCategory::find($id);
        if (!$packageCategory) {
            return response()->json([
                'status' => 201,
                'message' => "Record not available.."
            ]);
        }
        if ($request->hasFile('image')) {
            $ImagePath = public_path($packageCategory->image);
            unlink($ImagePath);
            $image_name = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('category_image'), $image_name);
        }

        $packageCategory->destinations()->sync($request->destinations_id);
        $result = $packageCategory->update([
            'title' => $request->title,
            'image' => 'category_image/' . $image_name,
            'description' => $request->description,
            'short_description' => $request->short_description ?: null
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'updated successfully....'
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
        $record = PackageCategory::find($id);
        if ($record) {
            $record->destinations()->detach();
            unlink(public_path($record->image));
            $record->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Deleted Successfully'
            ]);
            return response()->json([
                'status' => 201,
                'message' => 'Record not available....'
            ]);
        }
    }
}
