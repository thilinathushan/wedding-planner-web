<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCoupleIsSetUp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user does NOT have a couple record associated with them
        // and they are not already on the onboarding page (to prevent a redirect loop).
        if (! $request->user()->couple && ! $request->routeIs('onboarding.*')) {
            // If they don't, redirect them to the setup page.
            return redirect()->route('onboarding.create');
        }

        // If they do have a couple record, let them proceed.
        return $next($request);
    }
}
