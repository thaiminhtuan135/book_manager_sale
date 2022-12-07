<?php

namespace App\Http\Middleware;

use App\Enums\StatusCode;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTVerify
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json([], StatusCode::UNAUTHORIZED);
            }
        } catch (\Throwable $e) {
            return response()->json(['code' => StatusCode::UNAUTHORIZED, 'status' => '認証トークンが見つかりません。'], StatusCode::UNAUTHORIZED);
        }
        return $next($request);
    }
}
