<?php

namespace App\Http\Requests\Task;

use App\DTO\GetTaskListDto;
use App\Services\TaskStatusService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return $this->query();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'nullable',
                Rule::in(TaskStatusService::getStatusList()),
            ],
            'user_id' => [
                'nullable',
                'integer',
            ],
            'finished_at' => [
                'nullable',
                'date',
            ],
            'limit' => [
                'nullable',
                'integer',
                'gt:0'
            ],
            'offset' => [
                'nullable',
                'integer',
                'gt:0'
            ],
        ];
    }

    public function toDto(): GetTaskListDto
    {
        return GetTaskListDto::fromArray($this->validationData());
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Status can be ' . implode(', ', TaskStatusService::getStatusList()) . '.',
            'user_id.integer' => 'User is not valid.',
            'finished_at.date' => 'Finished date is not valid.',
        ];
    }
}
