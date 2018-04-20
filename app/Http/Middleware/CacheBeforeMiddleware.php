<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheBeforeMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $key = $this->keygen($request->url());
        if (Cache::has($key)) {
            $content = Cache::get($key);
            return response($content);
        }

        return $next($request);
    }

    protected function keygen($url) {
        return 'route_' . str_slug($url);
    }

}
