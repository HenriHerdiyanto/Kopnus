<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobNews extends Model
{
    protected $table = 'jobs_news'; // ⬅️ ini penting

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
