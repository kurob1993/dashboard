<?php

namespace App\Http\Middleware;

use Closure;

class checkSession
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

        if(!$request->session()->get('username')){
            return redirect('/login');
            // return redirect('https://sso.krakatausteel.com');
        }
        return $next($request);
    }
}
