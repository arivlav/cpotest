<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ApiErrorResponse implements Responsable
{
    public function __construct(
        private string $message,
        private int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        private ?\Throwable $exception = null,
        private array $headers = []
    ) {}

    public function toResponse($request): ResourceResponse|Response
    {
        $response = [
            'success' => false,
            'message' => $this->message,
        ];

        if ($this->exception !== null && config('app.debug')) {
            $response['debug'] = [
                'message' => $this->exception->getMessage(),
                'file'    => $this->exception->getFile(),
                'line'    => $this->exception->getLine(),
                'trace'   => $this->exception->getTraceAsString()
            ];
        }

        return response()->json(
            $response,
            $this->code,
            $this->headers
        );
    }
}
