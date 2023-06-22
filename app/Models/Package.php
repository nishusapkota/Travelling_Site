<?php

namespace App\Models;

use App\Models\TourEnquiry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $fillable=[
        'location',
        'image',
        'package_category_id',
        'price',
        'overview',
        'duration',
        'destinations_id'
    ];
    function packageCategories(){
        return $this->belongsToMany('\App\Models\PackageCategory','package_package_categories','packages_id',
        'package_categories_id');
    }
    function packageincludes(){
        return $this->hasMany('\App\Models\PackageIncluded');
    }
    function tourEnquiries(){
        return $this->hasMany('TourEnquiry::class');
    }
    function destination(){
        return $this->belongsTo(Destination::class,'destinations_id');
    }
    function packageInDemand(){
        return $this->belongsTo('\App\Models\PackagesInDemand');
    }
}
