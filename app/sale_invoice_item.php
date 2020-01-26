<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_invoice_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
        'qty_remaining_return' => 'float',
    ];

    public function sale_invoice()
    {
        return $this->belongsTo('App\sale_invoice');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function unit()
    {
        return $this->belongsTo('App\other_unit');
    }

    public function tax()
    {
        return $this->belongsTo('App\other_tax');
    }
}
