<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_one_cost extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_one()
    {
        return $this->belongsTo('App\production_one');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }
}
