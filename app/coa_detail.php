<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class coa_detail extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }

    public function sale_detail()
    {
        return $this->belongsTo('App\sale_detail');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }
}
