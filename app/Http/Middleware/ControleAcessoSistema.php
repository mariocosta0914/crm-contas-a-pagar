<?php

namespace App\Http\Middleware;

use Closure;

class ControleAcessoSistema
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
        $type_user = auth()->user()->supervisor;
        if($type_user!=1){
            return redirect(route('home'));
        }
        return $next($request);
    }
}