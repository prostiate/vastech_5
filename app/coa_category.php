<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coa_category extends Model
{
    public function coa()
    {
        return $this->hasMany('App\coa');
    } 
}
