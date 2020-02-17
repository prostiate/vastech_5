<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class journal_opening_balance extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = "journal_opening_balances";

    public function journal_opening_balance_item()
    {
        return $this->hasMany('App\journal_opening_balance_item');
    }
    
    public function asset()
    {
        return $this->hasMany('App\asset');
    }
    
    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

}
