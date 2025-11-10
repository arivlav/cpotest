<?php

namespace App\Actions\Task;

use App\DTO\GetTaskListDto;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\TaskModel;

class GetTaskListAction
{
    public function execute(int $projectId, GetTaskListDto $dto)
    {
        return TaskModel::getTaskListByProjectId($projectId, $dto);
    }
}
