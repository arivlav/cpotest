<?php

use App\Http\Responses\ApiErrorResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return new ApiErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $e);
        });
        $exceptions->render(function (ValidationException $e) {
            $errorMessage = array_map(function($errors) {
                return implode("; ", $errors);
            }, $e->errors());
            return new ApiErrorResponse(implode("; ", $errorMessage), Response::HTTP_UNPROCESSABLE_ENTITY, $e);
        });

        $exceptions->render(function (HttpException $e) {
            return new ApiErrorResponse($e->getMessage(), $e->getStatusCode(), $e);
        });


    })->create();
