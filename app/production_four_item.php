<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_four_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_four()
    {
        return $this->belongsTo('App\production_four');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }
}
