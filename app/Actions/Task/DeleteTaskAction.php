<?php

namespace App\Actions\Task;

use App\Models\TaskModel;

class DeleteTaskAction
{
    public function execute(int $id): bool
    {
        $task = TaskModel::find($id);
        if ($task) {
            $task->delete();
        }
        return (bool) $task;
    }
}
