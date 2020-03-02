<?php

namespace App\Model\coa;

use Illuminate\Database\Eloquent\Model;

class default_account extends Model
{
    protected $guarded = [];

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa', 'account_id');
    }
}
