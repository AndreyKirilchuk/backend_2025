<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function registration(Request $request)
    {
        $v = validator($request->all(), [
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|string|min:3",
        ]);

        if($v->fails()) return $this->errors(errors: $v->errors());

        User::create($v->validated());

        return response()->json([
           "success" => true
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function auth(Request $request)
    {
        $v = validator($request->all(), [
            "email" => "required|email|max:255",
            "password" => "required|string|min:3",
        ]);

        if($v->fails()) return $this->errors(errors: $v->errors());

        if(!auth()->attempt($v->validated())) return $this->errors(code: 401, message: "Login failed");

        $user = auth()->user();
        $token = Str::uuid();
        $user->update(['token' => $token]);

        return response()->json([
            "token" => $token,
        ]);
    }
}
