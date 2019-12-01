<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_payment_methods extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_payment()
    {
        return $this->hasMany('App\purchase_payment');
    }

    public function sale_payment()
    {
        return $this->hasMany('App\sale_payment');
    }
}
