<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FAQ::all();
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
            'destination_id' => 'required|exists:destinations,id',
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faq = FAQ::create($validatedData);

        return response()->json([
            'message' => 'FAQ created successfully',
            'faq' => $faq
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
        $validatedData = $request->validate([
            'destination_id' => 'exists:destinations,id',
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faq = FAQ::findOrFail($id);
        if ($faq) {
            $faq->update($validatedData);

            return response()->json([
                'message' => 'FAQ updated successfully',
                'faq' => $faq
            ], 200);
        }
        return response()->json([
            'message' => 'failed to update record.. ',
        ], 202);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        if (!$faq) {
            return response()->json([
                'message' => 'No records found..'
            ], 202);
        }
        $faq->delete();
        return response()->json([
            'message' => 'FAQ deleted successfully'
        ], 200);
    }
}
