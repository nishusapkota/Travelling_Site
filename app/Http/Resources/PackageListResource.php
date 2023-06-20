<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return 
        [
            'id'=>$this->id,
            'location'=>$this->location,
            'image'=>asset($this->image),
            'price'=>$this->price,
            'review'=>$this->review,
            'rating'=>$this->rating,
            
        ];
    }
}
