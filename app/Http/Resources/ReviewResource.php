<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'destination_id'=>$this->destination->destination,
            'package_id'=>$this->package->location,
            'star'=>$this->star,
            'review'=>$this->review ?: null,
            'photos'=>json_decode($this->photos) ?: null
        ];
    }
}
