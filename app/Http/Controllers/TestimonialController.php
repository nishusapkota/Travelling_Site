<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonialRequest;
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
    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = Testimonial::create($request->all());
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
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTestimonialRequest $request, $id)
    {
        $testimonial = Testimonial::find($id);
        if($testimonial){
            $testimonial->update($request->all());
            return response()->json([
                'message' => 'Testimonial updated successfully...',
               'status'=>200
            ]);
        }
        return response()->json([
            'message' => 'Record not available...',
           'status'=>201
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
        $testimonial = Testimonial::find($id);
        if($testimonial){
            $testimonial->delete();
            return response()->json([
                'message' => 'Testimonial deleted successfully...',
               'status'=>200
            ]);
        }
        return response()->json([
            'message' => 'Record not available...',
           'status'=>201
        ]);
        
    }
}
