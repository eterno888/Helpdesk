<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ApiAuth
{
    /**
     * Обработка входящего запроса.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (request()->header('token') != config('handesk.api_token')) {
            return response()->json(['error' => 'unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
