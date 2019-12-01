<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_bundle_cost extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }
}
