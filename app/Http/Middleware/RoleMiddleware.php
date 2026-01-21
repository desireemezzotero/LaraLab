<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        /* Controlla se l'utente è loggato */
        if (!auth()->check()) {
            return redirect('login');
        }

        /*   Controlla se il tuo ruolo è tra quelli permessi per questa rotta */
        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Accesso negato: il tuo ruolo (' . $userRole . ') non ha i permessi necessari.');
        }

        return $next($request);
    }
}
