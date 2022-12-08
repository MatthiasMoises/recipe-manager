<?php

namespace App\Http\Middleware;

use Closure;
class AppTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('App-Token');

        if (!$token || $token !== 'xCKc90BKy2K2xRJc') {
            return response()->json([
                'error' => "token_invalid"
            ]);
        }

        return $next($request);
    }
}
