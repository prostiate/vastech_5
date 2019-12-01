<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_bundle_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\product', 'product_id');
    }

    public function bundle_product()
    {
        return $this->belongsTo('App\product', 'bundle_product_id');
    }
}
