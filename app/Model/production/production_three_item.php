<?php

namespace App\Model\production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_three_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_three()
    {
        return $this->belongsTo('App\Model\production\production_three');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }
}
