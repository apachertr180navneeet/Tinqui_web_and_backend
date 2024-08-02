<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Fruitcake\Cors\HandleCors as BaseHandleCors;

class CustomHandleCors extends BaseHandleCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $response)
    {
        //  $response = parent::addActualRequestHeaders($request, $response);

        // // Add your custom logic here to exclude routes with specific query parameters
        // if ($request->is('api/create_meet_room') && $request->has(['language_symbol', 'login_user_id'])) {
        //     $response->headers->remove('Access-Control-Allow-Origin');
        //     $response->headers->remove('Access-Control-Allow-Methods');
        //     $response->headers->remove('Access-Control-Allow-Headers');
        //     $response->headers->remove('Access-Control-Allow-Credentials');
        // }

        // return $response;
        return $next($request);
    }
}
