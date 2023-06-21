<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverPhoto extends Model
{
    use HasFactory;
    protected $fillable=[
        'location','cover_image','destination_id'
    ];
    function destination(){
        $this->belongsTo('\App\Models\Destination');
    }
}
