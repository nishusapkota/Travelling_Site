<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripEnquiryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'name'=>$this->name,
            'email'=>$this->email,
            'mobile_num'=>$this->mobile_num,
            'group_size'=>$this->group_size,
            'travel_dates'=>$this->travel_dates,
            'destination_id'=>$this->destination->destination ?: null,
            'estimate_budget'=>$this->estimate_budget,
            'budget_flexible'=>$this->budget_flexible,
            'primary_age'=>$this->primary_age,
            'experience'=>$this->experience ?: null
        ];
    }
}
