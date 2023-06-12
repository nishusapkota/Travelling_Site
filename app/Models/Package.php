<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'things_to_do_id',
        'price',
        'overview',
        'duration',
        'free_cancellation',
        'call_us_on'
    ];
}
