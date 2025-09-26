<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_origin',
        'city_regency',
        'regency',
        'province',
        'level', // SMA / SMK / (SMP)
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
