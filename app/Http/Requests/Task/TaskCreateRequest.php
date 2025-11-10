<?php

namespace App\Http\Requests\Task;

use App\DTO\CreateTaskDto;
use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Zа-яА-Я0-9\s]+$/u'
            ],
            'file' => [
                'nullable',
                'file',
                //'mime:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,ppt,pptx',
                'max:5000'
            ]
        ];
    }

    public function toDto(): CreateTaskDto
    {
        return CreateTaskDto::fromArray($this->validationData());
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'description.regex' => 'Task description can only contain letters, numbers, spaces and underscores.',
            'file.file' => 'File must be a file.',
            'file.mime' => 'File can only be a file of type: pdf, doc, docx, jpg, jpeg, png, xls, xlsx, ppt, pptx.',
            'file.max' => 'File size must be less than 5 MB.'
        ];
    }
}
