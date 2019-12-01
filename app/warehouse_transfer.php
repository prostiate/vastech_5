<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouse_transfer extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function from_warehouse()
    {
        return $this->belongsTo('App\warehouse', 'from_warehouse_id');
    }

    public function to_warehouse()
    {
        return $this->belongsTo('App\warehouse', 'to_warehouse_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function warehouse_transfer_item()
    {
        return $this->hasMany('App\warehouse_transfer_item');
    }
}
