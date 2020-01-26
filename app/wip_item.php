<?php

namespace App;

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
        return $this->belongsTo('App\wip');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }
}
