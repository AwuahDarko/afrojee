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
        // Skip if this is the language switch route itself
        if ($request->routeIs('language.switch')) {
            return $next($request);
        }
        
        // Check session first, then URL parameter, then default
        $sessionLocale = session('locale');
        $urlLocale = $request->get('lang');
        $defaultLocale = config('app.locale');
        
        $locale = $sessionLocale ?? $urlLocale ?? $defaultLocale;
        
        // Validate the locale
        $locales = ['en', 'es'];
        if (in_array($locale, $locales)) {
            app()->setLocale($locale);
            // Ensure session is set
            if (session('locale') !== $locale) {
                session()->put('locale', $locale);
            }
        }
        
        return $next($request);
    }
}
