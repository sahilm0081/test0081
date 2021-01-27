<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'bldg_no', 'street_no', 'zone_no','street_name', 'landmark', 'area','user_id'
    ];

}
