<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages_Included extends Model
{
    use HasFactory;
    protected $fillable=[
        'packages_id',
        'points'
    ];
}
