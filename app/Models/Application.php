<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['job_id', 'user_id', 'cv_file', 'status'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // relasi ke job
    public function job()
    {
        return $this->belongsTo(JobNews::class);
    }

    // relasi ke user (freelancer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
