<?php

namespace App\DTO;


readonly class CreateTaskDto
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $file = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            description: $data['description'] ?? null,
            file: $data['file'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'file' => $this->file,
        ];
    }

}
