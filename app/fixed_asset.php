<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fixed_asset extends Model
{
    protected $fillable = [
            'asset_id' ,
            'asset_name' ,
            'asset_number' ,
            'asset_account',
            'asset_desc',
            'asset_aqc_date',
            'asset_aqc_cost',
            'asset_aqc_credited',
            'dep_active' ,
            'dep_method',
            'dep_life',
            'dep_rate' ,
            'dep_account',
            'dep_account2' ,
            'dep_acc' ,
            'dep_date'     ,    
    ];
}
