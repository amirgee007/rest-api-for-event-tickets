<?php

namespace App\Exceptions;

use App\Http\Resources\ResponseResource;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
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
    public function render($request, Exception $exception)
    {
        // Don't override error handler if request is about OAuth
        // See: routes/web.php or laravel/passport for more info.
        if ($request->is('oauth/*') OR $request->is('login') OR $request->is('logout')) {

            return parent::render($request, $exception);
        }

        $response = new ResponseResource($request);

        if ($exception instanceof AuthenticationException) {

            $response->setHttpCode(401);
            $response->setMessage('You are not authorized.');
        } else if ($exception instanceof NotFoundHttpException) {

            $response->setHttpCode(404);
            $response->setMessage('Endpoint not found.');
        } else {

            $response->setHttpCode(400);
            $response->setMessage('Something is wrong: '.class_basename($exception));
        }

        return $response->response()->setStatusCode($response->getHttpCode());
    }


}
