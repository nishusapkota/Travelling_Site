<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAboutRequest;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = About::all();
        return response()->json([
            'status' => 200,
            'data' => AboutResource::collection($about)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAboutRequest $request, About $about)
    {
        $image_name = time() . "." . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('about_image'), $image_name);

        $result = $about->create([
            'description' => $request->description,
            'image' => 'about_image/' . $image_name,
            'img_title' => $request->img_title,
            'img_body' => $request->img_body,
            'client_count' => $request->client_count,
            'client_desc' => $request->client_desc
        ]);

        if ($result) {
            return response()->json([
                'status' => 200,
                'message' => 'About data created successfully..'
            ]);
        }
        return response()->json([
            'status' => 201,
            'message' => 'Failed to create about content..'
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
    public function update(StoreAboutRequest $request, $id)
    {
        $about = About::find($id);
        if (!$about) {
            return response()->json([
                'status' => 201,
                'message' => 'Content not available..'
            ]);
        }

        if($request->hasfile('image')){
            $image_path = public_path($about->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image_name = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('about_image'), $image_name);
        }
       
        $result = $about->update([
            'description' => $request->description,
            'image' => 'about_image/' . $image_name,
            'img_title' => $request->img_title,
            'img_body' => $request->img_body,
            'client_count' => $request->client_count,
            'client_desc' => $request->client_desc
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Updated successfully....'
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
        $about = About::find($id);
        if ($about) {
            $image_path = public_path($about->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $result = About::destroy($id);
            return response()->json([
                'status' => 200,
                'message' => 'Deleted Successfully..'
            ]);
        }
        return response()->json([
            'status' => 201,
            'message' => 'Record not found'
        ]);
    }
}
