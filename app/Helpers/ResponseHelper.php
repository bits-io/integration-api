<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResponseHelper
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'meta' => [
                'success' => true,
                'message' => $message,
                'code' => $code,
            ],
            'list_data' => $data,
            'errors' => null,
        ], $code);
    }

    public static function error($message = 'Error', $code = 400, $errors = null)
    {
        return response()->json([
            'meta' => [
                'success' => false,
                'message' => $message,
                'code' => $code,
            ],
            'list_data' => null,
            'errors' => $errors,
        ], $code);
    }

    public static function handleError($e, $message = '')
    {
        $message = $message ?: $e->getMessage();
        $code = 500;

        if ($e instanceof ModelNotFoundException) {
            $message = $e->getMessage();
            $code = 404;
        }

        if ($e instanceof NotFoundHttpException) {
            $message = $e->getMessage();
            $code = 404;
        }

        if ($e instanceof BadRequestHttpException) {
            $message = $e->getMessage();
            $code = 400;
        }

        return self::error($message, $code);
    }
}
