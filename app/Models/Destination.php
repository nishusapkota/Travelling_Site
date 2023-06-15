<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'description'
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
}
