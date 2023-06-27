<?php

namespace App\Http\Resources;

use App\Models\Review;
use App\Models\Package;
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
        $package=Package::find($this->id);
        $count = Review::where('package_id',$package->id)->count();
        $sum = Review::where('package_id',$package->id)->sum('rating');
            if ($count > 0) {
                $avg_rating = round(($sum / $count), 2);
            } else {
                $avg_rating = "No Rating";
            }
        return [
            'title'=>$this->title,
            'price'=>$this->price,
            'overview'=>$this->overview,
            'duration'=>$this->duration,
            'review_count'=>$count,
            'star'=>$avg_rating,
            'destination_id'=>$this->destinations_id,
            'destination_name'=>$this->destination->destination
        ];
    }
}
