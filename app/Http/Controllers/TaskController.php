<?php

namespace App\Http\Controllers;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\DeleteTaskAction;
use App\Actions\Task\GetTaskListAction;
use App\Actions\Task\ShowTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskListRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\Schedule\ScheduleService;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    public function __construct(
        private readonly GetTaskListAction $getTaskAction,
        private readonly CreateTaskAction  $createTaskAction,
        private readonly ShowTaskAction $showTaskAction,
        private readonly UpdateTaskAction $updateTaskAction,
        private readonly DeleteTaskAction $deleteTaskAction,
    ) {}


    // Список всех запланированных уроков
    public function index(int $projectId, TaskListRequest $request)
    {
        $filtersDto = $request->toDto();
        $taskList= $this->getTaskAction->execute($projectId, $filtersDto);

        return new ApiSuccessResponse(
                [
                    'taskList' => $taskList,
                ]
            );
    }

    public function store(int $projectId, TaskCreateRequest $request)
    {
        $task = $this->createTaskAction->execute($projectId, $request);

        return new ApiSuccessResponse(
            $task,
            Response::HTTP_CREATED
        );
    }

    public function show(int $id)
    {
        $task = $this->showTaskAction->execute($id);
        if (!$task) {
            return new ApiErrorResponse('Task not found', Response::HTTP_NOT_FOUND);
        }
        return new ApiSuccessResponse(
            ['task' => $task],
            Response::HTTP_OK
        );
    }

    public function update(int $id, TaskUpdateRequest $request)
    {
        $task = $this->updateTaskAction->execute($id, $request);
        if (!$task) {
            return new ApiErrorResponse('Task not found', Response::HTTP_NOT_FOUND);
        }
        return new ApiSuccessResponse(['task' => $task], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $taskIsDeleted = $this->deleteTaskAction->execute($id);
        if (!$taskIsDeleted) {
            return new ApiErrorResponse('Task not found', Response::HTTP_NOT_FOUND);
        }
        return new ApiSuccessResponse(['message' => 'Task deleted'], Response::HTTP_NO_CONTENT);
    }

}
