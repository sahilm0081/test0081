<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //
    protected $fillable = [
        'title','description','cover_image','lat','lng','user_id' 
    ];
}
