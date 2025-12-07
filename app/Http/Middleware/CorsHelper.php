<?php
namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CorsHelper
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // If the response is not a proper response object, wrap it
        if (!$response instanceof SymfonyResponse) {
            $response = response($response);
        }

        // Add CORS headers
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", "Content-Type, Authorization");

        return $response;
    }
}


// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Response;

// class CorsHelper
// {
//     public function handle($request, Closure $next)
//     {
//         $response = $next($request);

//         if ($response instanceof Response) {
//             $response->header("Access-Control-Allow-Origin", "*")
//                 ->header("Access-Control-Allow-Methods", "*")
//                 ->header("Access-Control-Allow-Headers", "*");
//         }

//         return $response;
//     }
// }
