<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagesInDemand extends Model
{
    use HasFactory;
    protected $fillable=['package_id'];
    function package(){
        return $this->belongsTo('\App\Models\Package');
    }
}
