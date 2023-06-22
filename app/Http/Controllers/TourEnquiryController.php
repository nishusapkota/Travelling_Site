<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTourEnquiryRequest;
use App\Http\Resources\TourEnquiryResource;
use App\Models\TourEnquiry;
use Illuminate\Http\Request;

class TourEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TourEnquiryResource::collection(TourEnquiry::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTourEnquiryRequest $request)
    {
        TourEnquiry::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile_no'=>$request->mobile_no,
            'num_of_person'=>$request->num_of_person,
            'package_id'=>$request->package_id,
            'tour_date'=>$request->tour_date,
            'enquiry'=>$request->enquiry
        ]);
        return response()->json([
            'message'=> 'Tour enquiry created successfully',
            'status'=> 201
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTourEnquiryRequest $request, $id)
    {
        $tourEnquiry = TourEnquiry::find($id);

        if (!$tourEnquiry) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        $tourEnquiry->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile_no'=>$request->mobile_no,
            'num_of_person'=>$request->num_of_person,
            'package_id'=>$request->package_id,
            'tour_date'=>$request->tour_date,
            'enquiry'=>$request->enquiry
        ]);
        return response()->json([
            'message'=> 'Tour enquiry updated successfully',
            'status'=> 201
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
        $tourEnquiry = TourEnquiry::find($id);

        if (!$tourEnquiry) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
    
        $tourEnquiry->delete();
    
        return response()->json([
            'message' => 'Record deleted successfully',
        ], 200);
    }
}
