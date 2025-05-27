<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponses
{
    protected function ok($message, $data)
    {
        return $this->success($message, $data, 200);
    }

    protected function success($message, $data, $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    protected function error(string $message, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, array $errors = [])
    {

        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'status' => $statusCode,
        ], $statusCode);
    }

    protected function badRequest($errors = [])
    {
        return $this->error('Bad Request', Response::HTTP_BAD_REQUEST, $errors);
    }

    protected function unauthorized()
    {
        return $this->error('Não autorizado', Response::HTTP_UNAUTHORIZED);
    }

    protected function invalidCredentials()
    {
        return $this->error('Credenciais inválidas', Response::HTTP_UNAUTHORIZED);
    }

    protected function forbidden()
    {
        return $this->error('Não autorizado', Response::HTTP_FORBIDDEN);
    }

    protected function notFound()
    {
        return $this->error('Não encontrado', Response::HTTP_NOT_FOUND);
    }

    protected function unprocessableEntity($errors)
    {
        // include the errors in the response
        return response()->json([
            'message' => 'Unprocessable Entity',
            'errors' => $errors,
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function created($message, $data)
    {
        return $this->success($message, $data, Response::HTTP_CREATED);
    }

    protected function noContent($message)
    {
        return response()->json($message, Response::HTTP_NO_CONTENT);
    }
}
