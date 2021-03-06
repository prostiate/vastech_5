<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_fifo_out extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function product_fifo_out_fk_pd()
    {
        return $this->hasMany('App\Model\product\product_fifo_out_fk_sd', 'product_fifo_out_id');
    }

    public function product_fifo_out_fk_pi()
    {
        return $this->hasMany('App\Model\product\product_fifo_out_fk_si', 'product_fifo_out_id');
    }

    public function product_fifo_out_fk_wip()
    {
        return $this->hasMany('App\Model\product\product_fifo_out_fk_wip', 'product_fifo_out_id');
    }
}
