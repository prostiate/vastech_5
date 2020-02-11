<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class opening_balance extends Model
{
    protected $guarded = [];

    public function opening_balance_detail()
    {
        return $this->hasMany('App\opening_balance_detail');
    }
}
