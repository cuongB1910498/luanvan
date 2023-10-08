<?php

namespace App\Http\Middleware;

use Closure;

class PreventGetRequests
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
        if (!$request->isMethod('post')) {
            return redirect()->back()->with('error', 'Phương thức không được hỗ trợ.');
        }
    
        return $next($request);
    }
}
