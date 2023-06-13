<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'description',
        'destination_id'
    ];
    function destination() 
    {
        return $this->belongsTo('\App\Models\Destination');
    }

    function package(){
        return $this->hasMany('\App\Models\Package');
    }
}

