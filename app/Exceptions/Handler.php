<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

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
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //valida que el metodo de request sea el correcto 
        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            $message = Response::$statusTexts[$code];

            return $this->errorResponse($message, $code);
        }

        //Valida los errores al no encontrar un id enviado
        if ($e instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($e->getModel()));

            return $this->errorResponse("No se encontró ningun registro de {$model} con el id enviado", Response::HTTP_NOT_FOUND);
        }

        //Valida los errores de autorisacion
        if ($e instanceof AuthorizationException) {            
            return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        //Valida los errores de autenticacion
        if ($e instanceof AuthenticationException) {            
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->getMessages();

            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //controlar error de la API externa, en este caso el gateway actua como cliente
        if ($e instanceof ClientException) {
            $message = $e->getResponse()->getBody();
            $code = $e->getCode();

            return $this->errorMessage($message, $code);
        }


        //valida si la aplicacion esta en modo desarrollo para mostrar el error con mas detalles
        if (env('APP_DEBUG', false)) {
            return parent::render($request, $e);    
        }

        return $this->errorResponse('Error inesperado. Intente nuevamente', Response::HTTP_INTERNAL_SERVER_ERROR);
        
    }
}
