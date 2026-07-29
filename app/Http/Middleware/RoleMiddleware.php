<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        if (! auth()->check()) {
            abort(401);
        }


        if (! in_array(auth()->user()->role, $roles)) {

            if (auth()->user()->isPimpinan()) {

                return redirect()
                    ->route('dashboard')
                    ->with(
                        'error',
                        'Fitur perubahan data hanya tersedia untuk operator.'
                    );

            }

            abort(403);
        }


        return $next($request);
    }
}
