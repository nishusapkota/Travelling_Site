<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable=[
        'description',
        'image',
        'img_title',
        'img_body',
        'icon',
        'client_count',
        'client_desc'
    ];
}
