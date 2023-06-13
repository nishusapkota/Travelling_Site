<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package_Category extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'description',
        'destination_id'
    ];
}
