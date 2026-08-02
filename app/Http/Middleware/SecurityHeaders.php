<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and add security headers to the response.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // The nonce must exist before the view renders: both @vite and the
        // inline <script> blocks in the layouts read it from here.
        $nonce = Vite::useCspNonce();

        $response = $next($request);

        $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy($nonce));

        // Isolate the top-level window from documents it opens or that open it.
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        // Redundant with frame-ancestors, kept for older browsers.
        $response->headers->set('X-Frame-Options', 'DENY');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy (formerly Feature Policy)
        $response->headers->set('Permissions-Policy',
            'geolocation=(), microphone=(), camera=()'
        );

        return $response;
    }

    /**
     * Build the CSP. Every script is first-party, so neither 'unsafe-inline'
     * nor 'unsafe-eval' is needed: inline blocks carry the request nonce and
     * 'strict-dynamic' covers the modules Vite loads from them.
     *
     * Inline `style` attributes are still allowed because skill icons stored in
     * the database may carry one; style attributes are not a script sink.
     */
    private function contentSecurityPolicy(string $nonce): string
    {
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' 'strict-dynamic'",
            "style-src 'self' 'unsafe-inline'",
            "font-src 'self'",
            // Kept broad on purpose: image URLs are stored absolute against the
            // production domain, which is not 'self' on a preview deployment.
            "img-src 'self' data: blob: https:",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
            "object-src 'none'",
        ];

        // In development, allow Vite dev server
        if (app()->environment('local')) {
            $csp[] = "connect-src 'self' ws://localhost:* ws://127.0.0.1:* http://localhost:* http://127.0.0.1:*";
        } else {
            $csp[] = "connect-src 'self'";
            $csp[] = 'upgrade-insecure-requests';
            // No code writes to innerHTML or eval, so DOM sinks can be locked
            // down. Kept out of local because the Vite dev overlay uses innerHTML.
            $csp[] = "require-trusted-types-for 'script'";
        }

        return implode('; ', $csp);
    }
}
