<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name','type','province_id','province','lat','lng','raw'
    ];
    protected $casts = ['lat'=>'float','lng'=>'float','raw'=>'array'];
}
