<?php

namespace App\Models;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'description',
        'short_description'
    ];
    function destinations()
    {
        return $this->belongsToMany(Destination::class,
        'destination_package_categories',
        'package_categories_id','destinations_id');

    }

    function packages(){
        return $this->belongsToMany('\App\Models\Package','package_package_categories','packages_id'
        ,'package_categories_id');
    }
}

