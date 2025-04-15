<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationTokenNotFoundException::class,
        ThrottleRequestsException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response|ResponseAlias
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|Response|ResponseAlias
    {
        if (!$request->wantsJson())
        {
            if ($e instanceof ModelNotFoundException)  {
                return response('', 404);
            }

            return parent::render($request, $e);
        }

        $code = (int) $e->getCode();

        if ($code < 100 || $code > 599) {
            $code = ResponseAlias::HTTP_BAD_REQUEST;
        }

        if ($e instanceof NotFoundHttpException) {
            $code = ResponseAlias::HTTP_NOT_FOUND;
        }

        $data = ['Type' => 'Unknown error', 'Exception' => get_class($e)];
        $message = $e->getMessage();
        $message = blank($message) ? get_class($e) . ' | Unknown error' : $message;

        if (app()->environment() != 'production') {
            $data = $e->getTrace();
        }

        if ($e instanceof ValidationException) {
            $data = $e->validator->errors();
            $code = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
            $message = 'Invalid data';
        }

        $api = api($data);
        if ($e instanceof BaseException) {
            $api->details($e->getDetails());
        }

        if ($e instanceof AuthenticationException) {
            $code = ResponseAlias::HTTP_UNAUTHORIZED;
            return $api->fails($message, $code);
        }

        // Handle AuthorizationTokenNotFoundException
        if ($e instanceof AuthorizationTokenNotFoundException) {
            $code = ResponseAlias::HTTP_UNAUTHORIZED;
            $message = 'Authorization token not found';
            return $api->fails($message, $code);
        }

        if ($e instanceof ThrottleRequestsException) {
            $code = ResponseAlias::HTTP_TOO_MANY_REQUESTS;
            $message = 'Too many request';
            return $api->fails($message, $code);
        }


        return $api->fails($message, $code, (int) $e->getCode(), $data);
    }


    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse | RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse | RedirectResponse
    {
        if ($request->expectsJson()) {
            $api = api([]);
            return $api->fails('Unauthenticated', ResponseAlias::HTTP_UNAUTHORIZED);
        }
      //  return redirect()->guest(route('admin::auth.login.page'));
    }
}
