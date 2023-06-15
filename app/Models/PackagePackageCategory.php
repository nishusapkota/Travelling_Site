<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePackageCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'package_categories_id',
        'packages_id'
    ];
}

