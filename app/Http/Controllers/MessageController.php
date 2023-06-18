<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message=Message::all();
        return response()->json([
            'status'=>200,
            'data'=>MessageResource::collection($message)
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
       $this->validate($request,[
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'message' => 'required'
       ]);

       $message=Message::create([
        'name'=> $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'message' => $request->message
       ]);

       return response()->json(['message' => 'success'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message=Message::find($id);
       
        if($message){
            return $message;
        }
        return response()->json([
            'message'=>'Result Not Found...'
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
        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required'
           ]); 
        $message=Message::find($id);

        if(!$message){
            return response()->json([
                'status'=>201,
                'message'=>"Record not available.."
            ]);
        }

      
           
        $message->name=$request->name;
        $message->phone=$request->phone;
        $message->email=$request->email;
        $message->message=$request->message;

       
        $message->save();
        return response()->json([
            'status'=>200,
            'message'=>'message updated successfully'
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
        $result=Message::destroy($id);
        if($result){
            return response()->json([
                'status'=>200,
                'message'=>'Message Deleted Successfully'
            ]);
        return response()->json([
            'status'=>201,
            'message'=>'Failed to delete message'
        ]);
        }

    }
}
