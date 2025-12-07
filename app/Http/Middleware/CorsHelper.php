<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CorsHelper
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $response->header("Access-Control-Allow-Origin", "*")
                ->header("Access-Control-Allow-Methods", "*")
                ->header("Access-Control-Allow-Headers", "*");
        }

        return $response;
    }
}
