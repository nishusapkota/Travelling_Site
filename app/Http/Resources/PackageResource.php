<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'location'=>$this->location,
            'image'=>asset($this->image),
            'price'=>$this->price,
            'overview'=>$this->overview,
            'duration'=>$this->duration,
            'destination_id'=>$this->destinations_id,
            'destination_name'=>$this->destination->title
        ];
    }
}
