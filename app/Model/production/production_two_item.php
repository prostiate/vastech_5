<?php

namespace App\Model\production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_two_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_two()
    {
        return $this->belongsTo('App\Model\production\production_two');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }
}
