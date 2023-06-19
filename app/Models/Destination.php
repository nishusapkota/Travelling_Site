<?php

namespace App\Models;

use App\Models\PortraitImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'description',
        'short_description'
    ];

    function packageCategories()
    {
        return $this->belongsToMany(PackageCategory::class,
        'destination_package_categories','destinations_id',
        'package_categories_id');
    }
    
    function packages(){
        return $this->hasMany('\App\Models\Package');
    }

    function coverPhotos(){
        return $this->hasMany('\App\Models\CoverPhoto');
    }
    function portraitImages(){
        return $this->hasMany('PortraitImage');
    }
    function topDestination(){
        return $this->belongsTo('\App\Models\TopDestination');
    }
}
