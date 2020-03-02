<?php

namespace App\Model\coa;

use Illuminate\Database\Eloquent\Model;

class coa_category extends Model
{
    public function coa()
    {
        return $this->hasMany('App\Model\coa\coa');
    } 
}
