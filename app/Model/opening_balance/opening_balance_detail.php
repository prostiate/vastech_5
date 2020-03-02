<?php

namespace App\Model\opening_balance;

use Illuminate\Database\Eloquent\Model;

class opening_balance_detail extends Model
{
    protected $guarded = [];

    public function opening_balance()
    {
        return $this->belongsTo('App\Model\opening_balance\opening_balance');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa', 'account_id');
    }
}
