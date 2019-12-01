<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function product()
    {
        return $this->hasMany('App\product');
    } 
}
