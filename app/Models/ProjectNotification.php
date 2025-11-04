<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','owner_user_id','actor_user_id','actor_anon_key','type','payload'
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function project(){ return $this->belongsTo(Project::class); }
    public function owner(){ return $this->belongsTo(User::class, 'owner_user_id'); }
    public function actor(){ return $this->belongsTo(User::class, 'actor_user_id'); }
}
