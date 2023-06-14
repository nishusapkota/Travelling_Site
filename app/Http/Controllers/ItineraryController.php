<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Itinerary::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Itinerary $itinerary)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'package_id' => 'required|exists:packages,id',
            'body' => 'nullable|string',
        ]);
    
        $itinerary = Itinerary::create($validatedData);
    
        return response()->json(['message' => 'Itinerary created successfully', 'data' => $itinerary], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itinerary = Itinerary::findOrFail($id);

        return response()->json(['data' => $itinerary]);
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'package_id' => 'required|exists:packages,id',
            'body' => 'nullable|string',
        ]);
    
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->update($validatedData);
    
        return response()->json(['message' => 'Itinerary updated successfully', 'data' => $itinerary]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itinerary = Itinerary::findOrFail($id);
    $itinerary->delete();

    return response()->json(['message' => 'Itinerary deleted successfully']);

    }
}
