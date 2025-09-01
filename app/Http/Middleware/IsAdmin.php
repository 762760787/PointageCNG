<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Rediriger vers le dashboard employé si l'utilisateur n'est pas admin
        return redirect()->route('employe.dashboard')->with('error', 'Accès non autorisé.');
    }
}