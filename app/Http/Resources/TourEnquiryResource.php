<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourEnquiryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
        'name'=>$this->name,
        'email'=>$this->email,
        'mobile_no'=>$this->mobile_no,
        'num_of_person'=>$this->num_of_person,
        'package'=>$this->package->location,
        'tour_date'=>$this->tour_date,
        'enquiry'=>$this->enquiry
        ];
    }
}
