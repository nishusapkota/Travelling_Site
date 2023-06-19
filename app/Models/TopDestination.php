<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopDestination extends Model
{
    use HasFactory;
    protected $fillable=['destination_id'];
    function destination(){
        return $this->belongsTo('\App\Models\Destination');
    }
}
