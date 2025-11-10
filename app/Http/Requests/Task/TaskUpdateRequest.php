<?php

namespace App\Http\Requests\Task;

use App\Actions\Task\UpdateTaskAction;
use App\DTO\GetTaskListDto;
use App\DTO\UpdateTaskDto;
use App\Services\TaskStatusService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
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
        return $this->all();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' =>
            [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Zа-яА-Я0-9\s]+$/u'
            ],
            'status' => [
                'nullable',
                Rule::in(TaskStatusService::getStatusList()),
            ],
            'user_id' => [
                'nullable',
                'integer',
                'exists:users,id'
            ],
            'finished_at' => [
                'nullable',
                'date',
            ],
            'file' => [
                'nullable',
                'file',
                //'mime:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,ppt,pptx',
                'max:5000'
            ]
        ];
    }

    public function toDto(): UpdateTaskDto
    {
        return UpdateTaskDto::fromArray($this->validationData());
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'description.regex' => 'Task description can only contain letters, numbers, spaces and underscores.',
            'status.in' => 'Status can be ' . implode(', ', TaskStatusService::getStatusList()) . '.',
            'user_id.integer' => 'User is not valid.',
            'user_id.exists' => 'User is not valid.',
            'finished_at.date' => 'Finished date is not valid.',
        ];
    }
}
