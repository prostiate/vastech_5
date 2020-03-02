<?php

namespace App\Model\spk;

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
        return $this->belongsTo('App\Model\spk\spk');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function spk_item_status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }
    
    public function wip()
    {
        return $this->belongsTo('App\Model\wip\wip', 'selected_wip_id');
    }
}
