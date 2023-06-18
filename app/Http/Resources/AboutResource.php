<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
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
        'description'=>$this->description,
        'image'=>!is_null($this->image)?asset($this->image):null,
        'img_title'=>$this->img_title,
        'img_body'=>$this->img_body,
        'icon'=>!is_null($this->image)?asset($this->icon):null,
        'client_count'=>$this->client_count,
        'client_desc'=>$this->client_desc,
            
        ];
    }
}
