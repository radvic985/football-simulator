<?php

namespace App\Http\Middleware;

use App\Support\Constants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GenerateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array((int)$request->get('team_count'), Constants::AVAILABLE_TEAM_COUNTS)) {
            $message = 'Team count does not match available team counts';
            Log::error('GenerateMatchesMiddlewareError: ' . $message);

            return response('Error: ' . $message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $next($request);
    }
}
