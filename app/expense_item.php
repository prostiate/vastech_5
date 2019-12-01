<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expense_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function expense()
    {
        return $this->belongsTo('App\expense');
    }

    public function expense_id()
    {
        return $this->belongsTo('App\expense');
    }

    public function tax()
    {
        return $this->belongsTo('App\other_tax');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }
}
