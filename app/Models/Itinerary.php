<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;
    protected $fillable=[
        'day',
        'short_description',
        'package_id',
        'description'
    ];
    function package(){
        return $this->belongsTo('\App\Models\Package');
    }
}
