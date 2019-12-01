<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class default_account extends Model
{
    protected $guarded = [];

    public function coa()
    {
        return $this->belongsTo('App\coa');
    } 
}
