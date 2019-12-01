<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expense extends Model
{
    //protected $primaryKey = ['id', 'ref_id'];
    use SoftDeletes;
    protected $guarded = [];

    public function expense_contact()
    {
        return $this->belongsTo('App\contact', 'contact_id');
    }

    public function expense_item()
    {
        return $this->hasMany('App\expense_item');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function expense_status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa', 'pay_from_coa_id');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\other_payment_methods', 'payment_method_id');
    }

    public function term()
    {
        return $this->belongsTo('App\other_term', 'term_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }
}
