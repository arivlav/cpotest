<?php

namespace App\DTO;


use App\Enums\TaskStatusType;

readonly class UpdateTaskDto
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $status = null,
        public ?string $finishedAt = null,
        public ?int $userId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            description: $data['description'] ?? null,
            status: $data['status'] ?? null,
            finishedAt: $data['finished_at'] ?? null,
            userId: $data['user_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status ?? TaskStatusType::PLANNED->value,
            'finished_at' => $this->finishedAt,
            'user_id' => $this->userId ?? auth()->id(),
        ];
    }

}
