<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheAfterMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);
        
        $key = $this->keygen($request->url());

        if (!Cache::has($key)) {
            Cache::put($key, $response->getContent(), 1);
        }

        return $next($request);
    }

    protected function keygen($url) {
        return 'route_' . str_slug($url);
    }

}
