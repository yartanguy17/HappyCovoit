<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
         if (!$request->session()->get('is_admin')  && $request->session()->get('is_admin') <= 0) {
            return redirect('/admin/login')->with('flash_message_error', 'Accès intedit! Veuillez vous connecter.');
        }
        return $next($request);
    }
}
