<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Model ini tanpa timestamps (created_at/updated_at).
     */
    public $timestamps = false;

    /**
     * Kolom yang bisa diisi mass-assignment.
     * - nim  : untuk mahasiswa
     * - nik  : untuk dosen (GANTI dari nip/nidn → sekarang satu kolom nik)
     */
    protected $fillable = [
        'nim',           // mahasiswa
        'nik',           // dosen (Nomor Induk Kepegawaian)
        'name_asli',
        'username',
        'email',
        'role',          // admin | dosen | mahasiswa
        'password',
        // tambahkan kolom lain bila ada, mis. 'status', 'avatar_path', dst.
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     * - password: hashed (fitur Laravel 10+)
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /* ===========================
     |          RELASI
     |===========================*/
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function campusActs()
    {
        return $this->hasMany(CampusAct::class);
    }

    public function skillsMhs()
    {
        return $this->hasMany(Skills::class);
    }

    public function school()
    {
        return $this->hasOne(School::class);
    }

    public function profilDosen()
    {
        return $this->hasOne(ProfilDosen::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function latestProject()
    {
        // Jika punya kolom tanggal konsisten, bisa pakai ->latestOfMany('project_date')
        return $this->hasOne(Project::class)->latestOfMany('id');
    }

    /* ===========================
     |          SCOPES
     |===========================*/
    public function scopeMahasiswa($q)
    {
        return $q->where('role', 'mahasiswa');
    }

    public function scopeDosen($q)
    {
        return $q->where('role', 'dosen');
    }

    public function scopeKaprodi($q)
    {
        return $q->where('role', 'kaprodi');
    }

    public function scopeAdmin($q)
    {
        return $q->where('role', 'admin');
    }

    /**
     * NIM valid: 8 digit numerik (contoh aturan kampusmu).
     */
    public function scopeValidNim($q)
    {
        return $q->whereNotNull('nim')
            ->whereRaw("CHAR_LENGTH(nim) = 8")
            ->whereRaw("nim REGEXP '^[0-9]+$'");
    }

    /**
     * NIK valid: fleksibel (alfanumerik, max 32).
     * Kalau kampusmu hanya angka, ganti regex menjadi ^\d{10,12}$ misalnya.
     */
    public function scopeValidNik($q)
    {
        return $q->whereNotNull('nik')
            ->whereRaw("CHAR_LENGTH(nik) <= 32")
            ->whereRaw("nik REGEXP '^[A-Za-z0-9]+$'"); // izinkan huruf/angka
    }

    /* ===========================
     |       ACCESSORS / HELPERS
     |===========================*/

    /**
     * Mengembalikan tahun angkatan (2022, 2025, ...) atau null jika NIM tak valid.
     */
    public function getCohortAttribute()
    {
        if (is_string($this->nim) && preg_match('/^\d{8}$/', $this->nim)) {
            return (int) ('20' . substr($this->nim, 2, 2));
        }
        return null;
    }

    /**
     * Helper cepat peran.
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    public function isKaprodi(): bool
    {
        return $this->role === 'kaprodi';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
