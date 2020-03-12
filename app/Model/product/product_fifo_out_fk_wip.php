<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_fifo_out_fk_wip extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product_fifo_out()
    {
        return $this->belongsTo('App\Model\product\product_fifo_out', 'product_fifo_out_id');
    }

    public function wip()
    {
        return $this->belongsTo('App\Model\wip\wip', 'wip_id');
    }
}
