<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class spk_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
        'qty_remaining_sent' => 'float',
    ];

    public function spk()
    {
        return $this->belongsTo('App\spk');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function spk_item_status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
    
    public function wip()
    {
        return $this->belongsTo('App\wip', 'selected_wip_id');
    }
}
