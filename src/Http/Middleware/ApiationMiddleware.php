<?php declare(strict_types=1);

namespace Apiation\ApiationLaravel\Http\Middleware;

use Apiation\ApiationLaravel\Facades\ApiationLaravel;
use Closure;
use Illuminate\Http\JsonResponse;

class ApiationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var JsonResponse $response */
        $response = $next($request);

        if(!$request->acceptsJson()){
            return $response;
        }

        try {
            ApiationLaravel::record($request, $response);
        } finally{
            return $response;
        }
    }

}
