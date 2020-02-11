<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class closing_book extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $cast = [
        "start_period" => "date",
        "end_period" => "date"
    ];
}
