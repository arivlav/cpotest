<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ApiSuccessResponse implements Responsable
{
    public function __construct(
        private mixed $data,
        private int   $code = Response::HTTP_OK,
        private array $headers = []
    )
    {
    }

    public function toResponse($request): ResourceResponse|Response
    {
        return response()->json(
            [
                'success' => true,
                'data' => $this->data,
            ],
            $this->code,
            $this->headers
        );
    }
}
