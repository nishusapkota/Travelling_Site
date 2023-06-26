<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAboutRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
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
        $contact = Contact::all();
        return response()->json([
            'status' => 200,
            'data' => ContactResource::collection($contact)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request, Contact $contact)
    {
        $contact->create([
            'description' => $request->description,
            'address' => $request->address,
            'phone' => json_encode($request->input('phone')),
            'email' => $request->email
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Created successfully....'
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
    public function update(StoreContactRequest $request, $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => 201,
                'message' => 'Contact not available..'
            ]);
        }
        $contact->update([
            'description' => $request->description,
            'address' => $request->address,
            'phone' => json_encode($request->input('phone')),
            'email' => $request->email
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'updated successfully....'
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
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => 201,
                'message' => 'Record not available....'
            ]);
        }
        $contact->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Contact Deleted Successfully'
        ]);
    }
}
