<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $role)
    {
/*
var_dump( auth()->user()->role);
echo"\n";
var_dump ($role );
exit;
*/
        if (!auth()->check())
            return redirect('login');


        if(auth()->user()->role === 'editar')
            return $next($request);

        if (auth()->user()->role === $role) {
            return $next($request);
        }
    
        abort(403, 'No tiene permiso para acceder a esta página.');
        //return redirect('/');
    }
}
