<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Inertia\Inertia;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        switch ($response->status()) {
            case 404:
                return Inertia::render('404');
                break;
            // case 500:
            //     return Inertia::render('Errors/500');
            //     break;
            // case 401:
            //     return Inertia::render('Erros/NotSubscribed');
            //     break;
            default:
                return $response;
                break;
        }
    }
}
