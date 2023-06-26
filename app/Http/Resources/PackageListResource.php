<?php

namespace App\Http\Resources;

use App\Models\Package;
use App\Models\PackageImage;
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
        $result=PackageImage::where('package_id',$this->id)->first();
        return 
        [
            'id'=>$this->id,
            'title'=>$this->title,
            'image'=>asset($result->image),
            'price'=>$this->price,
            'review'=>$this->review,
            'rating'=>$this->rating,
            
        ];
    }
}
