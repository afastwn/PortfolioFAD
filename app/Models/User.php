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
    public function projects()          { return $this->hasMany(Project::class); }
    public function latestProject()
    {
        return $this->hasOne(Project::class)->latestOfMany('id'); 
        // kalau punya kolom tanggal yang konsisten:
        // return $this->hasOne(Project::class)->latestOfMany('project_date');
    }

    // di dalam class User extends Authenticatable
    public function scopeMahasiswa($q)
    {
        return $q->where('role', 'mahasiswa');
    }

    public function scopeValidNim($q)
    {
        return $q->whereNotNull('nim')
            ->whereRaw("CHAR_LENGTH(nim) = 8")
            ->whereRaw("nim REGEXP '^[0-9]+$'");
    }

    /** Mengembalikan tahun angkatan (2022, 2025, ...) atau null jika nim tak valid */
    public function getCohortAttribute()
    {
        if (is_string($this->nim) && preg_match('/^\d{8}$/', $this->nim)) {
            return (int) ('20' . substr($this->nim, 2, 2));
        }
        return null;
    }



}
