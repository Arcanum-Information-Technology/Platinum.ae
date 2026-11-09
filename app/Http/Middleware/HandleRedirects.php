<?php

namespace App\Http\Middleware;

use App\Services\RedirectService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function __construct(
        protected RedirectService $redirectService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        // Don't intercept POST/PUT/DELETE or admin routes or assets
        if (!$request->isMethod('GET') || $request->is('admin*') || $request->is('storage*') || $request->is('build*')) {
            return $next($request);
        }

        $redirect = $this->redirectService->findRedirect($request->getRequestUri());

        if ($redirect) {
            $redirect->recordHit();
            return redirect($redirect->destination_url, $redirect->status_code);
        }

        return $next($request);
    }
}
