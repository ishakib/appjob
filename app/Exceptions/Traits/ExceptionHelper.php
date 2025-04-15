<?php


namespace App\Exceptions\Traits;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\TokenMismatchException;
use Throwable;

trait ExceptionHelper
{
    private function isDatabaseConnectionFailure(Throwable $exception): bool
    {
        return $exception instanceof QueryException;
    }

    public function apiFailResponse($request, Throwable $exception): ?JsonResponse
    {
        if (!$request->expectsJson()) {
            return null;
        }

        $message = $exception->getMessage();
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        if ($exception instanceof QueryException) {
            $message = 'Database query failed.';
            $statusCode = 424;
        }

        if ($exception instanceof ModelNotFoundException) {
            $message = 'Resource not found';
            $statusCode = 404;
        }

        if ($exception instanceof TokenMismatchException) {
            $message = trans('default.csrf_token_mismatch_message') == 'default.csrf_token_mismatch_message' ?
                'CSRF token mismatch.' : trans('default.csrf_token_mismatch_message');
            $statusCode = 419;
        }

        return response()->json(['status' => false, 'message' => $message], $statusCode);
    }

    public function whenItIs23000($request, Throwable $exception)
    {
        return trans('default.this_resource_already_referenced_message');
    }
}
