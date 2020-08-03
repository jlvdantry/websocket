<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if( config('app.debug')===false &&
            (
            $exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
            || $exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException
            // || $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
            )
        ){
            // By overriding this function, I make Laravel display my custom 500 error page instead of the
            // 'Whoops, looks like something went wrong.' message in Symfony\Component\Debug\ExceptionHandler
            return response()->view("llave.runtime-error", ['exception' => $exception], 500);
        }else{
            return parent::render($request, $exception);
        }   
    }


}
