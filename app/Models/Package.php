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
        'duration'
    ];
    function packageCategory(){
        return $this->belongsTo('\App\Models\PackageCategory');
    }
    function packageincludes(){
        return $this->hasMany('\App\Models\PackageIncluded');
    }
}
