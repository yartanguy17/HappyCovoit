<?php

namespace App\Http\Middleware;

use Closure;

class Compagnie
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
        if (!$request->session()->get('is_compagnie') && $request->session()->get('is_compagnie') <= 0) {
            return redirect('/login-compagnie')->with('flash_message_error', 'Accès intedit! Veuillez vous connecter.');
        }
        return $next($request);
    }
}
