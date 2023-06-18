<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial=Testimonial::all();
        return response()->json([
            'status'=>200,
            'message'=>TestimonialResource::collection($testimonial)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required',
            'description' => 'required',
            'rating' => 'required',
            'position' => 'nullable',
        ]);
    
        $testimonial = Testimonial::create($validatedData);
    
        return response()->json([
            'message' => 'Testimonial created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);

    return response()->json([
       'message'=>'testimonial created successfully..'
    ], 200);
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
        $validatedData = $request->validate([
            'name'=>'required',
            'description' => 'required',
            'rating' => 'required',
            'position' => 'nullable',
        ]);
    
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($validatedData);
    
        return response()->json([
            'message' => 'Testimonial updated successfully.'
           
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
    $testimonial->delete();

    return response()->json([
        'message' => 'Testimonial deleted successfully.',
    ], 200);
    }
}
