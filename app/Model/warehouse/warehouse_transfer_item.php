<?php

namespace App\Model\warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouse_transfer_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
    ];

    public function warehouse_transfer()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse_transfer');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }
}
