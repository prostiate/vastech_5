<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cashbank_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function cashbank()
    {
        return $this->belongsTo('App\cashbank');
    }

    public function expense()
    {
        return $this->belongsTo('App\expense', 'expense_id');
    }

    public function tax()
    {
        return $this->belongsTo('App\other_tax');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa', 'receive_from');
    }
}
