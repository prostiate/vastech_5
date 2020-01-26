<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_discount_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = ['qty' => 'float'];

    public function product()
    {
        return $this->belongsTo('App\product');
    }
}
