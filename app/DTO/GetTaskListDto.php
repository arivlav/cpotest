<?php

namespace App\DTO;


readonly class GetTaskListDto
{
    public function __construct(
        public ?string $status = null,
        public ?string $userId = null,
        public ?string $finishedAt = null,
        public ?int    $limit = null,
        public ?int    $offset = 0,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'] ?? null,
            userId: $data['user_id'] ?? null,
            finishedAt: $data['finished_at'] ?? null,
            limit: $data['limit'] ?? config('api.defaultLimit'),
            offset: $data['offset'] ?? 0,
        );
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'user_id' => $this->userId,
            'finished_at' => $this->finishedAt,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
    }

}
