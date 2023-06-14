<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageIncluded extends Model
{
    use HasFactory;
    protected $fillable=[
        'package_id',
        'description'
    ];
    function package(){
        return $this->belongsTo('\App\Models\Package');
    }
}
