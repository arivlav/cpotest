<?php

namespace App\Actions\Task;

use App\Models\TaskModel;

class ShowTaskAction
{
    public function execute(int $id): array
    {
        $currentTask = TaskModel::with('user', 'media')->find($id);
        $task = $currentTask->toArray();
        $task['file_url'] = $currentTask->getFirstMediaUrl('tasks');
        return $task;
    }
}
