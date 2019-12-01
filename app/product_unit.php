<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_unit extends Model
{
    protected $table = 'units';

    protected $fillable = [
        'name',
    ];
}
