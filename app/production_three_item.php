<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_three_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_three()
    {
        return $this->belongsTo('App\production_three');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }
}
