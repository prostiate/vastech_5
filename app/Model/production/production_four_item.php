<?php

namespace App\Model\production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_four_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_four()
    {
        return $this->belongsTo('App\Model\production\production_four');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }
}
