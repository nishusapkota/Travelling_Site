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
        return $this->hasMany(PackageCategory::class,'destination_id');
    }
}
