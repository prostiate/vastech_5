<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouse_transfer_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function warehouse_transfer()
    {
        return $this->belongsTo('App\warehouse_transfer');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }
}
