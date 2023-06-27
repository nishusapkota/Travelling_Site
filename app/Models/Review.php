<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable=[
        'destination_id',
        'package_id',
        'rating',
        'review',
        'photos'
    ];
    function destination(){
        return $this->belongsTo('\App\Models\Destination');
    }
    function package(){
        return $this->belongsTo('\App\Models\Package');
    }
    
}
