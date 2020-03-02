<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_payment_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sale_payment()
    {
        return $this->belongsTo('App\Model\sales\sale_payment');
    }

    public function sale_invoice()
    {
        return $this->belongsTo('App\Model\sales\sale_invoice', 'sale_invoice_id');
    }
}
