<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expense_detail extends Model
{
    protected $fillable = [
        'expense_id',
    ];

    public function expense()
    {
        return $this->hasMany('App\expense');
    }

    public function expense_account()
    {
        return $this->hasMany('App\expense_account');
    }
}
