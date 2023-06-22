<?php

namespace App\Models;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripEnquiry extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'mobile_num',
        'group_size',
        'travel_dates',
        'destination_id',
        'estimate_budget',
        'budget_flexible',
        'primary_age',
        'experience'
    ];
    function destination(){
        return $this->belongsTo('\App\Models\Destination');
    }

}
