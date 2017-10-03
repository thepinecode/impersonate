<?php

namespace Pine\Impersonate\Http\Middleware;

use Closure;

class CannotImpersonateItself
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route('user') == $request->user()->id) {
            return response('Forbidden.', 403);
        }

        return $next($request);
    }
}
