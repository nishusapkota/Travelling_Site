<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contact::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Contact $contact)
    {
        $request->validate([
            'description'=>'required',
            'address'=>'required',
            'phone'=>'required|array',
            'email'=>'required|email'
        ]);
       
        $result=$contact->create([
            'description'=>$request->description,
            'address'=>$request->address,
            'phone'=>json_encode($request->input('phone')),
            'email'=>$request->email
        ]);
        if($result){
            return response()->json([
                'message'=>'Created successfully....'
            ]);
        }
        return response()->json([
            'message'=>'Fail to create....'
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
        $contact=Contact::find($id);
        if($contact){
            return $contact;
        }
        return response()->json([
            'message'=>'record isnot available...'
        ]);
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
        'description'=>'required',
            'address'=>'required',
            'phone'=>'required|array',
            'email'=>'required|email'
    ]);
    $contact=Contact::find($id);
    if(!$contact){
        return response()->json([
            'message'=>'Contact not available..'
        ]);
    }
    $result=$contact->update([
        'description'=>$request->description,
        'address'=>$request->address,
        'phone'=>json_encode($request->input('phone')),
        'email'=>$request->email
    ]);
    if($result){
        return response()->json([
            'message'=>'updated successfully....'
        ]);
    }
    return response()->json([
        'message'=>'Fail to update ....'
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
        $result=Contact::destroy($id);
      if($result){
        return response()->json([
            'message'=>'Contact Deleted Successfully'
        ]);
    return response()->json([
        'message'=>'Failed to delete contact'
    ]);
    }
    }
}
