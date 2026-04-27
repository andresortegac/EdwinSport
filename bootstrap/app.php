<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DeveloperMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'admin'     => AdminMiddleware::class,
            'developer' => DeveloperMiddleware::class,

            'admin_or_dev' => DeveloperMiddleware::class, // ✅ agregado
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            $postMaxSize = (string) (ini_get('post_max_size') ?: '8M');
            $uploadMaxSize = (string) (ini_get('upload_max_filesize') ?: '2M');
            $message = 'La carga supera el limite del servidor (POST: '
                . $postMaxSize
                . ', archivo: '
                . $uploadMaxSize
                . '). Reduce el peso o la cantidad de archivos e intenta de nuevo.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'error' => 'post_too_large',
                ], Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
            }

            $errorBag = $request->routeIs('events.fixture.report.store')
                ? 'fixtureReport'
                : 'default';

            return back()
                ->withErrors(['upload' => $message], $errorBag)
                ->withInput();
        });
    })
    ->create();
