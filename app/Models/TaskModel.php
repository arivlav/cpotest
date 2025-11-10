<?php

namespace App\Models;

use App\DTO\GetTaskListDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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

    static public function getTaskListByProjectId(int $projectId, GetTaskListDto $dto): Collection
    {
        return self::where('project_id', '=' , $projectId)
            ->select(
                [
                    'tasks.id',
                    'tasks.title',
                    'tasks.description',
                    'tasks.status',
                    'tasks.finished_at',
                    'tasks.user_id as creator_id',
                    'users.name as creator_name'
                ]
            )
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->where(function ($query) use ($dto) {
                if ($dto->status) {
                    $query->where('status', $dto->status);
                }
                if ($dto->userId) {
                    $query->where('user_id', $dto->userId);
                }
                if ($dto->finishedAt) {
                    $query->where('finished_at', '<=', $dto->finishedAt);
                }
                if ($dto->offset) {
                    $query->skip($dto->offset);
                }
                if ($dto->limit) {
                    $query->take($dto->limit);
                }
            })
            ->get();
    }
}
