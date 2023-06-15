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
        'description'
    ];
    function destinations()
    {
        return $this->belongsToMany(Destination::class,
        'destination_package_categories',
        'package_categories_id','destinations_id');
    }

    function package(){
        return $this->hasMany('\App\Models\Package');
    }
}

