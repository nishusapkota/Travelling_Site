<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
 
class Blog extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable=[
       // 'description',
        'image',
        'title',
        'body'
    ];
}
