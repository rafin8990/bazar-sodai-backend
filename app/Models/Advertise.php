<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $table = 'advertise';

    protected $fillable = [
        'title',
        'description',
        'image',
        'btn_text',
        'btn_link',
        'status',
    ];

}
