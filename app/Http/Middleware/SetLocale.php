<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there's a language parameter in the URL or session
        $locale = $request->get('lang') ?? session('locale', config('app.locale'));
        
        // Validate the locale
        $locales = ['en', 'es'];
        if (in_array($locale, $locales)) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
        }
        
        return $next($request);
    }
}
