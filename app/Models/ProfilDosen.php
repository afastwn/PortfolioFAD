<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilDosen extends Model
{
    use HasFactory;

    protected $table = 'profil_dosen';

    protected $fillable = [
        'user_id',
        'department',
        'academic_advisor',
        'personal_email',
        'phone_number',
        'avatar_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
