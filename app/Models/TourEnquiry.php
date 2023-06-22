<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourEnquiry extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'mobile_no',
        'num_of_person',
        'package_id',
        'tour_date',
        'enquiry'
    ];
    function package(){
        return $this->belongsTo('\App\Models\Package');
    }
}
