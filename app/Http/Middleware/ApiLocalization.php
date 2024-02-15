<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check header request and determine localizaton
        $locale = ($request->hasHeader('X-Localization')) ? $request->header('X-Localization') : 'id';
        // set laravel localization
        app()->setLocale($locale);
        // Continue request
        return $next($request);
    }
}
