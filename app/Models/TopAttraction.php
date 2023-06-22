<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopAttraction extends Model
{
    use HasFactory;
    protected $fillable=[
        'destination_id',
        'tags',
        'name',
        'link'
    ];

}
