<?php

namespace App\Tools;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionHandler
{
    public static function handle(Throwable $e)
    {
        switch (get_class($e)) {
            case AuthorizationException::class:
                return response()->json([
                    'message' => 'Não autorizado...',
                    'status' => Response::HTTP_FORBIDDEN,
                ], Response::HTTP_FORBIDDEN);
            case NotFoundHttpException::class:
            case ModelNotFoundException::class:
                return response()->json([
                    'message' => 'Não encontrado',
                    'status' => Response::HTTP_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            case AuthenticationException::class:
                return response()->json([
                    'message' => 'Não autenticado',
                    'status' => Response::HTTP_UNAUTHORIZED,
                ], Response::HTTP_UNAUTHORIZED);
            case AccessDeniedHttpException::class:
                return response()->json([
                    'message' => 'Acesso negado',
                    'status' => Response::HTTP_FORBIDDEN,
                ], Response::HTTP_FORBIDDEN);
        }

        info('***Exception Handler@40: ' . get_class($e) . ' ( ' . $e->getMessage() . ' )');

        // info($e->getTraceAsString());
        return response()->json([
            'message' => 'Erro desconhecido',
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
