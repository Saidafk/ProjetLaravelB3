<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, $next)
    {
        if (! $request->user() || ! $request->user()->subscribed('default')) {
            return response()->json(['error' => 'Abonnement requis pour accéder à cette ressource.'], 403);
        }

        return $next($request);
    }
}
