<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class opening_balance_detail extends Model
{
    protected $guarded = [];

    public function opening_balance()
    {
        return $this->belongsTo('App\opening_balance');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa', 'account_id');
    }

}
