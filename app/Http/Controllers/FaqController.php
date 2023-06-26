<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Resources\FAQResource;
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
        return FAQResource::collection(FAQ::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFaqRequest $request)
    {
        $faq = FAQ::create($request->all());
        return response()->json([
            'message' => 'FAQ created successfully',
            'faq' => $faq
        ], 200);
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
    public function update(StoreFaqRequest $request, $id)
    {
        $faq = FAQ::find($id);
        if ($faq) {
            $faq->update($request->all());
            return response()->json([
                'status'=>200,
                'message' => 'FAQ updated successfully',
                'faq' => $faq
            ]);
        }
        return response()->json([
            'status'=>201,
            'message' => 'Record not available.. ',
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
        $faq = FAQ::find($id);
        if (!$faq) {
            return response()->json([
                'status'=>201,
                'message' => 'No records found..'
            ]);
        }
        $faq->delete();
        return response()->json([
            'status'=>200,
            'message' => 'FAQ deleted successfully'
        ]);
    }
}
