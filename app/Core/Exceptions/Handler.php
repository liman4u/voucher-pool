<?php

namespace App\Core\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        //if (env('APP_DEBUG')) {
          //  return parent::render($request, $e);
        //}

        $success = false;
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;


        if ($e instanceof HttpResponseException) {

            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        } elseif ($e instanceof MethodNotAllowedHttpException) {

            $status = Response::HTTP_METHOD_NOT_ALLOWED;
            $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);

        } elseif ($e instanceof NotFoundHttpException) {

            $status = Response::HTTP_NOT_FOUND;
            $e = new NotFoundHttpException('HTTP_NOT_FOUND', $e);

        }  elseif ($e) {

            $e = new HttpException($status, 'HTTP_INTERNAL_SERVER_ERROR');

        }

        return response()->json([
            'success' => $success,
            'message' => $e->getMessage()
        ], $status);

    }
}
