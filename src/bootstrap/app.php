<?php

use App\Exceptions\BaseException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (BaseException $e, Request $request) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        });
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json(['message' => $e->getMessage()], $e->status);
        });
    })->create();
