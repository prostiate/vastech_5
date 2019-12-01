<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expense_account extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function expense()
    {
        return $this->belongsTo('App\expense');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }
}