<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopAttraction;

class TopAttractionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    return TopAttraction::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'tags' => 'required|array',
            'name' => 'required|string',
            'link' => 'required|string',
        ]);
    
        $topAttraction = new TopAttraction();
        $topAttraction->create([
            'destination_id'=>$request->destination_id,
            'tags'=>json_encode($request->tags),
            'name'=>$request->name,
            'link'=>$request->link
        ]);
    return response()->json([
            'message' => 'Top Attraction created successfully',
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
        //
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
        'destination_id' => 'exists:destinations,id',
        'tags' => 'required|array',
        'name' => 'string',
        'link' => 'string',
    ]);

    $topAttraction = TopAttraction::find($id);

    if (!$topAttraction) {
        return response()->json([
            'message' => 'Top Attraction not found',
        ], 404);
    }

    $topAttraction->update([
        $topAttraction->destination_id = $request->destination_id,
        $topAttraction->tags = json_encode($request->tags),
        $topAttraction->name = $request->name,
        $topAttraction->link = $request->link

    ]);
    return response()->json([
        'message' => 'Top Attraction updated successfully',
        'data' => $topAttraction,
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
    $topAttraction = TopAttraction::find($id);

    if (!$topAttraction) {
        return response()->json([
            'message' => 'Top Attraction not found',
        ], 404);
    }

    $topAttraction->delete();

    return response()->json([
        'message' => 'Top Attraction deleted successfully',
    ], 200);
}

}
