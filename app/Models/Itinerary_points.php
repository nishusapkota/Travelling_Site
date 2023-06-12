<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary_points extends Model
{
    use HasFactory;
    protected $fillable=[
        'itinerary_id',
        'points'
    ];
}
