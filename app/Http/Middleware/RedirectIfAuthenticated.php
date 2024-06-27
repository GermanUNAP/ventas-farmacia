<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Lógica adicional personalizada
                // Ejemplo: registrar una actividad del usuario autenticado
                $user = Auth::guard($guard)->user();
                // Aquí puedes registrar la actividad, como guardar un registro en la base de datos
                \Log::info('Usuario autenticado', ['user_id' => $user->id]);

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}

