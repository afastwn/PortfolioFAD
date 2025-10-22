<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','anonim_name','title','category','course','client','project_date','semester',
        'design_brief','design_process','spec_material','spec_size',
        'final_product_photos','design_process_photos','testing_photos','display_photos',
        'poster_images','videos','views','likes',
    ];

    protected $casts = [
        'project_date'          => 'date',
        'semester'              => 'integer',
        'final_product_photos'  => 'array',
        'design_process_photos' => 'array',
        'testing_photos'        => 'array',
        'display_photos'        => 'array',
        'poster_images'         => 'array',
        'videos'                => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ========= Helpers untuk tampilan ========= */

    // Cover grid: ambil Display Photo index 0
    public function getDisplayCoverUrlAttribute(): ?string
    {
        $arr = $this->display_photos ?? [];
        if (!count($arr)) return null;
        $path = $arr[0];
        return $this->toPublicUrl($path);
    }

    // --- Accessor untuk preload di form edit (dipakai di Blade JS) ---
    public function getFinalProductUrlsAttribute(): array
    {
        return $this->mapToUrls($this->final_product_photos);
    }

    public function getDesignProcessUrlsAttribute(): array
    {
        return $this->mapToUrls($this->design_process_photos);
    }

    public function getTestingPhotoUrlsAttribute(): array
    {
        return $this->mapToUrls($this->testing_photos);
    }

    public function getDisplayPhotoUrlsAttribute(): array
    {
        return $this->mapToUrls($this->display_photos);
    }

    public function getPosterUrlsAttribute(): array
    {
        return $this->mapToUrls($this->poster_images);
    }

    /* ========= Util kecil ========= */

    protected function mapToUrls($arr): array
    {
        $arr = is_array($arr) ? $arr : [];
        return array_map(fn ($p) => $this->toPublicUrl($p), $arr);
    }

    protected function toPublicUrl(?string $path): ?string
    {
        if (!$path) return null;
        // kalau sudah URL penuh, kembalikan apa adanya
        if (preg_match('~^https?://~i', $path)) return $path;
        // kalau path storage, convert ke asset('storage/...') (butuh storage:link)
        return asset('storage/'.$path);
    }
    
    public function getVideoUrlsAttribute(): array
    {
        return $this->mapToUrls($this->videos); // akan convert path storage → asset('storage/...')
    }
}
