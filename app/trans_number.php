<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class trans_number extends Model
{
    public function purchase_quote()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote');
    } 
}

