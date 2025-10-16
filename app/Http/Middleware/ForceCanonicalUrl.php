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

        // Respect proxies and load balancers
        $host = $request->header('X-Forwarded-Host') ?: $request->getHost();
        $forwardedProto = $request->header('X-Forwarded-Proto');
        $isSecure = ($forwardedProto === 'https') || $request->isSecure();

        // Skip redirects for CLI, local dev or asset requests
        if (app()->runningInConsole() || $request->is('storage/*') || $request->is('vendor/*') || $request->is('api/*')) {
            return $next($request);
        }

        $uri = $request->getRequestUri();
        $query = $request->getQueryString();

        // Normalize URI: strip accidental /public/ if the app was deployed incorrectly
        if (strpos($uri, '/public/') === 0) {
            $uri = substr($uri, 7);
        } elseif ($uri === '/public') {
            $uri = '/';
        }

        $shouldRedirectHost = (stripos($host, 'www.') === 0) || (strcasecmp($host, $canonicalHost) !== 0);
        $shouldRedirectScheme = ! $isSecure;

        if ($shouldRedirectHost || $shouldRedirectScheme) {
            $target = 'https://' . $canonicalHost . $uri;
            if ($query) {
                $target .= '?' . $query;
            }
            return redirect()->to($target, 301);
        }

        return $next($request);
    }
}
