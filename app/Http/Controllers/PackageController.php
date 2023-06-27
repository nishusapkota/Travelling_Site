<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Review;
use App\Models\Package;
use App\Models\Itinerary;
use App\Models\PackageImage;
use Illuminate\Http\Request;
use App\Http\Resources\PackageResource;
use App\Http\Requests\StorePackageRequest;


class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('destination')->get();
        return response()->json([
            'status' => 200,
            'data' => PackageResource::collection($packages)
        ]);
    }
    public function store(StorePackageRequest $request, Package $package)
    {
        $result = $package->create([
            'title' => $request->title,
            'price' => $request->price,
            'overview' => $request->overview,
            'duration' => $request->duration,
            'whats_included' => $request->whats_included,
            'destinations_id' => $request->destinations_id
        ]);
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $image_name = time() . "_" . $image->getClientOriginalName();
                $image->move(public_path('package_image'), $image_name);
                PackageImage::create([
                    'image' => 'package_image/' . $image_name,
                    'package_id' => $result->id
                ]);
            }
        }
        foreach ($request->day as $key => $day) {
            Itinerary::create([
                'day' => $day,
                'short_description' => $request->short_description[$key],
                'description' => $request->description[$key],
                'package_id' => $result->id
            ]);
        }
        $result->packageCategories()->attach($request->package_categories_id);
        if ($result) {
            return response()->json([
                'status' => 200,
                'message' => 'Package created successfully.'
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Failed to create package.'
        ]);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        if ($package) {
            $package->packageCategories()->detach();
            $packageImages = PackageImage::where('package_id', $package->id)->get();
            foreach ($packageImages as $packageImage) {
                $imagePath = public_path($packageImage->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $packageImage->delete();
            }
            if ($package->delete()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Package deleted successfully.'
                ]);
            }
        }
        return response()->json([
            'status' => 202,
            'message' => 'Record not available'
        ]);
    }

    function update(StorePackageRequest $request, $id)
    {
        $package = Package::where('id', $id)->first();
        $package->update([
            'title' => $request->title,
            'price' => $request->price,
            'overview' => $request->overview,
            'duration' => $request->duration,
            'whats_included' => $request->whats_included,
            'destinations_id' => $request->destinations_id
        ]);
        if ($request->hasFile('image')) {
            $package_images = PackageImage::where('package_id', $package->id)->get();
            foreach ($package_images as $packageImage) {
                $imagePath = public_path($packageImage->image);
                unlink($imagePath);
            }
            foreach ($request->file('image') as $image) {
                $image_name = time() . "_" . $image->getClientOriginalName();
                $image->move(public_path('package_image'), $image_name);
                PackageImage::create([
                    'image' => 'package_image/' . $image_name,
                    'package_id' => $package->id
                ]);
            }
        }

        $itineraries = Itinerary::where('package_id', $package->id)->get();
        foreach ($itineraries as $itinerary) {
            $itinerary->delete();
        }
        foreach ($request->day as $key => $day) {
            Itinerary::create([
                'day' => $day,
                'short_description' => $request->short_description[$key],
                'description' => $request->description[$key],
                'package_id' => $package->id
            ]);
        }
        $package->packageCategories()->attach($request->package_categories_id);
        return response()->json([
            'status' => 200,
            'message' => 'Package updated successfully.'
        ]);
    }
}
