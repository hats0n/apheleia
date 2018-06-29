<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuthentication
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
        $isLoggedIn = $request->session()->get('is_logged_in');
        if($request->getUri()=='/login' && $isLoggedIn){
            return redirect('/user/products');
        }

        if ($request->getPathInfo() !='/login' && !$isLoggedIn) {
            return redirect('/login');
        }
        return $next($request);
    }
}
