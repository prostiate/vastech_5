<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cashbank extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function cashbank_item()
    {
        return $this->hasMany('App\cashbank_item');
    }

    public function coa_pay_from()
    {
        return $this->belongsTo('App\coa', 'pay_from');
    }

    public function coa_transfer_from()
    {
        return $this->belongsTo('App\coa', 'transfer_from');
    }

    public function coa_deposit_to()
    {
        return $this->belongsTo('App\coa', 'deposit_to');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction', 'other_transaction_id');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }
}
