<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskModel extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TaskModelFactory> */
    use InteractsWithMedia, HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'finished_at',
        'user_id',
    ];


    protected $casts = [
        'finished_at' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
