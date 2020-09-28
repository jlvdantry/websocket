<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\Correo;
use App\AdipUtils\MailFactory;

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
        
        if( config('app.debug')===false &&
            config('engine.mailing_errors')!='' && 
            (
               $exception instanceof \Error // Parse errors, class not found y similares
            || $exception instanceof \ErrorException // Errores lanzados en tienmpo de ejecucion con trigger_error()
            || $exception instanceof \Illuminate\Database\QueryException // Errores de Base de Datos
            || $exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException // Subida de archivos excede tamaño
            )
        ){
            
            MailFactory::sendMail(
                new Correo([
                    'tx_from' => config('mail.from.address')
                    ,'tx_to' => config('engine.mailing_errors')
                    ,'tx_subject' => 'Informe de error en '.config('app.name')
                    ,'tx_body' => view('errors.report')->with(compact('exception'))->render()
                    ,'nu_priority' => 1
                ])
            );
        }
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
            )
        ){
            return response()->view("llave.runtime-error", ['exception' => $exception], 500);
        }else{
            return parent::render($request, $exception);
        }   
    }


}
