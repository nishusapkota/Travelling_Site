<?php

namespace App\Models;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory;
    protected $fillable=[
        'destination_id',
        'question',
        'answer'
    ];
    function destination() {
        return $this->belongsTo('Destination::class');
    }
}
