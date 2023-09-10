<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckIfUserAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->is_active) {
            return $next($request);
        }
    
        if ($request->user()) {
            Auth::logout(); // Log out the user if they are already logged in.
        }
    
        return Inertia::render('Pending',[
            401
        ])->toResponse($request)->setStatusCode(401);;
    }
}
