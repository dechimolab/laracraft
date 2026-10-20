<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheAuthenticated
{
    /**
     * Handle an incoming request.
     * Prevents browser caching on authenticated HTML pages while preserving download headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->isDownload($response)) {
            return $response;
        }

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    private function isDownload(Response $response): bool
    {
        $disposition = (string) $response->headers->get('Content-Disposition');
        if (stripos($disposition, 'attachment') !== false) {
            return true;
        }

        $contentType = (string) $response->headers->get('Content-Type');
        return $contentType !== '' && stripos($contentType, 'text/html') === false;
    }
}
