<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortraitImage extends Model
{
    use HasFactory;
    protected $fillable=[ 'title','image','destination_id','short_description'];
    function destination(){
        $this->belongsTo('\App\Models\Destination');
    }
}
