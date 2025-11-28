<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status === 'pending') {
            if ($request->routeIs('pending.notice') || $request->routeIs('logout')) {
                return $next($request);
            }
            return redirect()->route('pending.notice');
        }

        if (Auth::check() && Auth::user()->status === 'banned') {
            abort(403, 'Your account has been suspended.');
        }

        return $next($request);
    }
}