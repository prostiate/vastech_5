<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class history_limit_balance extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
