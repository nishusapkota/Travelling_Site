<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripEnquiryRequest;
use App\Http\Resources\TripEnquiryResource;
use App\Models\TripEnquiry;
use Illuminate\Http\Request;

class TripEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TripEnquiryResource::collection(TripEnquiry::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTripEnquiryRequest $request)
    {
        TripEnquiry::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile_num'=>$request->mobile_num,
            'group_size'=>$request->group_size,
            'travel_dates'=>$request->travel_dates,
            'destination_id'=>$request->destination_id ?: null,
            'estimate_budget'=>$request->estimate_budget,
            'budget_flexible'=>$request->budget_flexible == 'yes' ? 1 : 0 ,
            'primary_age'=>$request->primary_age,
            'experience'=>$request->experience ?: null
        ]);
        return response()->json([
            'message'=>'Inquiry created successfully',
            'status'=>201
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
    public function update(StoreTripEnquiryRequest $request, $id)
    {
      
        $tripEnquiry = TripEnquiry::find($id);

        if (!$tripEnquiry) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        $tripEnquiry->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile_num'=>$request->mobile_num,
            'group_size'=>$request->group_size,
            'travel_dates'=>$request->travel_dates,
            'destination_id'=>$request->destination_id ?: null,
            'estimate_budget'=>$request->estimate_budget,
            'budget_flexible'=>$request->budget_flexible == 'yes' ? 1 : 0 ,
            'primary_age'=>$request->primary_age,
            'experience'=>$request->experience ?: null
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
        $tripEnquiry = TripEnquiry::find($id);

        if (!$tripEnquiry) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
    
        $tripEnquiry->delete();
    
        return response()->json([
            'message' => 'Record deleted successfully',
        ], 200);
    }
}
