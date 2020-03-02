<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tenant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function company()
    {
        return $this->hasMany('App\Model\company\company');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
