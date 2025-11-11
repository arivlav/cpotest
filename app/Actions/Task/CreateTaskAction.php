<?php

namespace App\Actions\Task;

use App\Enums\TaskStatusType;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Mail\Task\TaskCreated;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Mail;

class CreateTaskAction
{
    public function execute(int $projectId, TaskCreateRequest $request): array
    {
        $newTask = $this->storeTask($projectId, $request);
        Mail::to($task->user?->email ?? auth()->user()->email)->send(new TaskCreated($newTask));
        $task = $newTask->toArray();
        $task['file_url'] = $newTask->getFirstMediaUrl('tasks');
        return [
            'newTask' => $task,
        ];
    }

    private function storeTask(int $projectId, TaskCreateRequest $request): TaskModel
    {
        $dto = $request->toDto();
        $newTask = new TaskModel();
        $newTask->project_id = $projectId;
        $newTask->title = $dto->title;
        $newTask->description = $dto->description;
        $newTask->status = TaskStatusType::PLANNED->value;
        $newTask->user_id = auth()->id();
        $newTask->save();
        if ($request->hasFile('file')) {
            $newTask->addMediaFromRequest('file')->toMediaCollection('tasks');
        }
        return $newTask;
    }
}
