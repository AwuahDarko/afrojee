<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitLog;

class LogWebsiteVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip logging for API routes or specific paths if needed
        if ($request->is(['api/*', 'admin/*'])) {
            return $next($request);
        }

        $userAgent = $request->userAgent();

        if ($this->isBot($userAgent)) {
            return $next($request);
        }

        VisitLog::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
        ]);

        return $next($request);
    }

    protected function isBot(?string $userAgent): bool
    {
        if (!$userAgent) {
            return true;
        }

        $botKeywords = [
            'bot',
            'crawl',
            'spider',
            'slurp',
            'facebookexternalhit',
            'mediapartners-google',
            'Googlebot',
            'Bingbot',
            'DuckDuckBot',
            'Yahoo! Slurp',
            'ia_archiver',
            'Twitterbot',
            'facebot',
            'WhatsApp',
            'TelegramBot',
        ];

        $pattern = '/' . implode('|', array_map('preg_quote', $botKeywords)) . '/i';

        return preg_match($pattern, $userAgent);
    }
}
