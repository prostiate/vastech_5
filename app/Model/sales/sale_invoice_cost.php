<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_invoice_cost extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }
}
