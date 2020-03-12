<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_fifo_in_fk_wip extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product_fifo_in()
    {
        return $this->belongsTo('App\Model\product\product_fifo_in', 'product_fifo_in_id');
    }

    public function wip()
    {
        return $this->belongsTo('App\Model\wip\wip', 'wip_id');
    }
}
