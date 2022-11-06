<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // * FUNCTION CAN'T GO TO THE INDEX PAGE IF THE USER IS NOT YET LOGGED IN
        if (!session()->has('adminEmail') && ($request->path() !='/'))
        {
            abort(404, 'Unauthorized User');
        }

        // * FUNCTION CAN'T GO BACK IF THE USER IS ALREADY LOGGED IN
        if (session()->has('adminEmail') && ($request->path() =='/'))
        {
            return redirect()->back();
        }
        return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
    }
}
