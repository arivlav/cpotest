<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    TaskController
};

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')
    ->group(
        function () {
            Route::prefix('/projects/{projectId}')
                ->group(
                    function () {
                        Route::get('/tasks', [TaskController::class, 'index'])
                            ->name('api.projects.tasks');
                        Route::post('/tasks', [TaskController::class, 'store'])
                            ->name('api.projects.tasks.store');
                    }
                );
            Route::prefix('/tasks/{id}')
                ->group(
                    function () {
                        Route::get('/', [TaskController::class, 'show'])
                            ->name('api.tasks');
                        Route::put('/', [TaskController::class, 'update'])
                            ->name('api.tasks.update');
                        Route::delete('/', [TaskController::class, 'delete'])
                            ->name('api.tasks.delete');
                    }
                );
        }
    );
