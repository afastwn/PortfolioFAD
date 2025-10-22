<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'email_pribadi',
        'motivation',
        'tags',
        'photo',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // URL siap-pakai untuk <img>
    public function getPhotoUrlAttribute(): string
    {
        if (!empty($this->photo)) {
            return asset('uploads/profiles/' . $this->photo);
        }
        return asset('images/avatar-mhs.png'); // siapkan default
    }
}
