<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class CheckTokenExpiration
{
    public function handle($request, Closure $next)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        if ($token && $token->expires_at && $token->expires_at->isPast()) {
            return response()->json([
                'message' => 'Token expirado',
                'success' => false
            ], 401);
        }

        return $next($request);
    }
}
