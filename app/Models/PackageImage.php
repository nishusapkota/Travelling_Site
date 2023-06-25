<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageImage extends Model
{
    use HasFactory;
    protected $fillable=[
        'image',
        'package_id'
    ];
    function package(){
        return $this->belongsTo('\App\Models\Package');
    }
}
