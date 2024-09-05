<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\ExternalServiceException\BookingServiceException;
use App\Exceptions\GeneralException\ActionNotPermittedException;
use App\Services\Constant;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e): void {
            //
        });
    }

    /**
     * @param $request
     * @throws Throwable
     */
    public function render($request, Throwable|Exception $e): Response
    {
        return $this->handleException($request, $e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @throws Throwable
     */
    public function handleException(Request $request, Throwable|Exception $exception): Response
    {
        if ($exception instanceof BookingServiceException && $request->wantsJson()) {
            return $this->handleBookingServiceException($exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(
                ['error' => $exception->getMessage()],
                Constant::NOT_FOUND
            );
        }

        if ($exception instanceof ActionNotPermittedException) {
            return response()->json(
                ['error' => $exception->getMessage()],
                Constant::BAD_REQUEST
            );
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return response()->json(['error ' => 'Unexpected Exception. Try later'], Constant::INTERNAL_SERVER_ERROR);
    }

    public function handleBookingServiceException(Throwable|Exception $exception): \Illuminate\Http\JsonResponse
    {
        $statusCode = $exception->getCode();
        return match ($statusCode) {
            Constant::BAD_REQUEST => response()->json(['error' => 'Missing require parameter'], $statusCode),
            Constant::UNAUTHORIZED => response()->json(
                ['error' => 'The API or Token supplied is invalid'],
                $statusCode
            ),
            Constant::REQUEST_FAILED => response()->json(
                ['error' => 'Parameters were valid but request failed'],
                $statusCode
            ),
            Constant::FORBIDDEN => response()->json(['error' => 'The supplied URL is not valid'], $statusCode),
            Constant::NOT_FOUND => response()->json(['error' => 'The requested item was not found'], $statusCode),
            default => response()->json(['error' => $exception->getMessage()], $exception->getCode())
        };
    }
}
