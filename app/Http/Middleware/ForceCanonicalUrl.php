<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceCanonicalUrl
{
    /**
     * Handle an incoming request.
     * Redirect to https://tabib-jo.com if host or scheme differs.
     */
    public function handle(Request $request, Closure $next)
    {
        $canonicalHost = 'tabib-jo.com';
        $host = $request->getHost();
        $isSecure = $request->isSecure() || $request->header('X-Forwarded-Proto') === 'https';

        // Skip redirects for CLI, local dev or asset requests
        if (app()->runningInConsole() || $request->is('storage/*') || $request->is('vendor/*')) {
            return $next($request);
        }

        $needsRedirect = false;

        if (strpos($host, 'www.') === 0) {
            $needsRedirect = true;
        }

        if (! $isSecure) {
            $needsRedirect = true;
        }

        if ($needsRedirect) {
            $uri = $request->getRequestUri();
            $target = 'https://' . $canonicalHost . $uri;
            return redirect()->to($target, 301);
        }

        return $next($request);
    }
}
