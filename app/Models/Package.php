<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
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
    function destination(){
        return $this->belongTo('\App\Models\Destination');
    }
}
