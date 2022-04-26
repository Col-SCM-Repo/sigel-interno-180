<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ControlAccesos
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
        Log::debug('accedeniendo al middleware');
        $usuario = Auth::user();
        Log::debug($usuario);
        
        if($usuario->USU_CARGO != 'AUXILIAR')
            return $next($request);

        throw new NotFoundHttpException("sadasd");
        
    }
}
