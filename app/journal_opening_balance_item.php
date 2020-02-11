<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class journal_opening_balance_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function journal_opening_balance()
    {
        return $this->belongsTo('App\journal_opening_balance');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }
}
