<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table = 'heroes';

    protected $fillable = [

        'name',
        'image',
        'price'
    ];

}
