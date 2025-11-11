<?php

namespace App\Actions\Task;

use App\Http\Requests\Task\TaskUpdateRequest;
use App\Models\TaskModel;

class UpdateTaskAction
{
    public function execute(int $id, TaskUpdateRequest $request): ?array
    {
        $task = TaskModel::find($id);
        if (!$task) return null;
        return $this->saveTask($task, $request);
    }

    private function saveTask(TaskModel $task, TaskUpdateRequest $request): ?array
    {
        $dto = $request->toDto();
        $task->fill($dto->toArray());
        $task->save();
        $arrTask = $task->toArray();
        $arrTask['file_url'] = $this->saveAndAddFileUrl($task, $request);
        return $arrTask;
    }

    private function saveAndAddFileUrl(TaskModel $task, TaskUpdateRequest $request): ?string
    {
        if ($request->hasFile('file')) {
            $task->clearMediaCollection('tasks');
            $task->addMediaFromRequest('file')->toMediaCollection('tasks');
            return $task->getFirstMediaUrl('tasks');
        }
        return null;
    }
}
