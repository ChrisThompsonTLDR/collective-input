<?php

namespace Christhompsontldr\CollectiveInput\Http\Middleware;

use Closure;

class CollectiveInput
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        /**
         *  Inject the JS or CSS
         */
        $content = $response->content();

        $content = preg_replace('!(<body[^>]*>)!', '$1' . 'taco', $content, 1);
dd($content);
        $response->setContent($content);

        return $response;
    }
}
