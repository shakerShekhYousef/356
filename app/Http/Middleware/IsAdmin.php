<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class IsAdmin
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
        //Check if the user is logged in
        if ($request->user() === null) {
            $response = response()->json([
                'message' => 'Unauthorized',
            ], 401);
            throw new HttpResponseException($response);
        }
        //Check if the user has admin role
        if ($request->user()->isAdmin) {
            return $next($request);
        } else {
            return forbidden_response('forbidden');
        }
    }
}
