<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\ResponseTrait;

class ChecToken
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if(!$token) return $this->errors(code: 403, message: 'Forbidden for you');

        $user = User::where('token', $token)->first();

        if(!$user) return $this->errors(code: 403, message: 'Forbidden for you');

        auth()->login($user);

        return $next($request);
    }
}
