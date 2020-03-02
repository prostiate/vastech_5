<?php

namespace App\Model\wip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class wip_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty_require' => 'float',
        'qty_total' => 'float',
    ];

    public function wip()
    {
        return $this->belongsTo('App\Model\wip\wip');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }
}
