<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_fifo_out_fk_si extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product_fifo_out()
    {
        return $this->belongsTo('App\Model\product\product_fifo_out', 'product_fifo_out_id');
    }

    public function sale_invoice()
    {
        return $this->belongsTo('App\Model\sales\sale_invoice', 'sale_invoice_id');
    }
}
