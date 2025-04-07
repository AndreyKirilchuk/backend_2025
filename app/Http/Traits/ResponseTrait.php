<?php

namespace App\Http\Traits;

trait ResponseTrait
{
    public function errors(int $code = 422, string $message = 'Invalid fields', mixed $errors = null)
    {
        $response = [
            "message" => $message,
        ];

        if($errors) $response["errors"] = $errors;

        return response()->json($response, $code);
    }
}
