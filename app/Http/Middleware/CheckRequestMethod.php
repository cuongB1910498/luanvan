<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequestMethod
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
        if ($request->isMethod('get')) {
            // Nếu yêu cầu sử dụng phương thức GET, đưa ra lỗi 404
            abort(404);
        }
        return $next($request);
    }
}
