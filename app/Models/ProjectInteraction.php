<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'user_id', 'anon_key',
        'liked', 'comments',
    ];

    protected $casts = [
        'liked' => 'boolean',
        'comments' => 'array',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
