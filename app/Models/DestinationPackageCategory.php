<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationPackageCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'destinations_id',
        'package_categories_id'
    ];
}
