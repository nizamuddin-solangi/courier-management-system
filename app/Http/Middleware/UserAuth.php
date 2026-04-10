<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user_logged_in')) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Please login first to track.',
                ], 401);
            }
            return redirect('/user/login')->with('error', 'Please sign in to continue.');
        }

        return $next($request);
    }
}

