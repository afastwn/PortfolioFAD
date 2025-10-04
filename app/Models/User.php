<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false; // 🔹 tidak pakai created_at & updated_at

    protected $fillable = [
        'nim',          // untuk mhs
        'nip',          // untuk dosen
        'nidn',         // untuk dosen
        'name_asli',
        'username',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function profile()         { return $this->hasOne(Profile::class); }
    public function campusActs()       { return $this->hasMany(CampusAct::class); }
    public function skillsMhs()          { return $this->hasMany(Skills::class); }
    public function school()          { return $this->hasOne(School::class); }
    public function profilDosen()     { return $this->hasOne(ProfilDosen::class);}

}
