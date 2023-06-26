<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopDestinationResource extends JsonResource
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
            'destination_id'=>$this->destination_id,
            'destination' => $this->destination->destination,
            'description' => $this->destination->description,
            'portrait_image' => asset($this->destination->portrait_image)
        ];
    }
}
