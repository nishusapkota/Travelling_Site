<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Message;
use App\Models\TourEnquiry;
use App\Models\TripEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\MessageResource;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\TourEnquiryResource;
use App\Http\Resources\TripEnquiryResource;
use App\Http\Requests\StoreTourEnquiryRequest;
use App\Http\Requests\StoreTripEnquiryRequest;

class EnquiryController extends Controller
{
    public function destroyReview($id)
    {
        DB::beginTransaction();
        try {
            $review = Review::find($id);
            if (!$review) {
                return response()->json([
                    'message' => 'Review not found',
                    'status' => 404
                ]);
            }
            // Delete review photos 
            $photos = json_decode($review->photos);
            if ($photos) {
                foreach ($photos as $photo) {
                    $photoPath = public_path('review_photo') . '/' . basename($photo);
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                }
            }
            $review->delete();
            DB::commit();

            return response()->json([
                'message' => 'Review deleted successfully',
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Oops! Something went wrong. Please try again',
                'status' => 400
            ]);
        }
    }

    public function storeReview(StoreReviewRequest $request)
    {
        DB::beginTransaction();
        try {
            $photos = []; // Initialize the $photos array here

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $img_name = time() . "_" . $photo->getClientOriginalName();
                    $photo->move(public_path('review_photo'), $img_name);
                    $photos[] = asset('review_photo/' . $img_name);
                }
            }
            Review::create([
                'destination_id' => $request->destination_id,
                'package_id' => $request->package_id,
                'rating' => $request->rating,
                'review' => $request->review ?: null,
                'photos' => json_encode($photos)
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Review created successfully',
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 400
            ]);
        }
    }

    public function indexReview()
    {
        return ReviewResource::collection(Review::all());
    }


    public function indexTrip()
    {
        return TripEnquiryResource::collection(TripEnquiry::all());
    }

    public function storeTrip(StoreTripEnquiryRequest $request)
    {
       // dd($request->all());
        TripEnquiry::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile_num'=>$request->mobile_num,
            'group_size'=>$request->group_size,
            'travel_dates'=>json_encode($request->travel_dates),
            'destination_id'=>$request->destination_id ?: null,
            'estimate_budget'=>$request->estimate_budget,
            'budget_flexible' => $request->budget_flexible,
            'primary_age'=>$request->primary_age,
            'experience'=>$request->experience ?: null
        ]);
        return response()->json([
            'message'=>'Inquiry created successfully',
            'status'=>201
        ]);
    }

    public function destroyTrip($id)
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


    public function indexTour()
    {
        return TourEnquiryResource::collection(TourEnquiry::all());
    }

    public function storeTour(StoreTourEnquiryRequest $request)
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


    public function destroyTour($id)
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

    public function indexMessage()
    {
        $message=Message::all();
        return response()->json([
            'status'=>200,
            'data'=>MessageResource::collection($message)
        ]);
    }

    public function storeMessage(Request $request)
    {
       $this->validate($request,[
        'name' => 'required',
        'phone' => 'required|numeric|digits:10',
        'email' => 'required|email',
        'message' => 'nullable'
       ]);

    Message::create([
        'name'=> $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'message' => $request->message ?:null
       ]);

       return response()->json(['message' => 'success'],200);
    }
   
    public function destroyMessage($id)
    {
        $message=Message::find($id);
        
        $result=$message->delete();
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
