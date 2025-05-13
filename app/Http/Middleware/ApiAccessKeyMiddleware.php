<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAccessKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $validAccessKey = config('services.api.access_key');
        $requestAccessKey = $request->header('X-API-Key');

        if (!$requestAccessKey || $requestAccessKey !== $validAccessKey) {

            return ApiResponse::error(message: 'Invalid or missing API access key', status: 401);

        }

        return $next($request);
    }
}