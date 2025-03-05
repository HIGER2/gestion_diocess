<?php

namespace App\Http\Middleware;

use App\Models\RegsiterLink;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthRegisterLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token'); // Obtenir le token de la route
        $user = Auth::guard('register_link')->user();

        // Vérifier si l'utilisateur est connecté, mais avec le token correspondant
        if (!$user) {
            return redirect()->route('login.link.authenticate', ['token' => $token]);
        }

        // Vérifier si l'utilisateur authentifié correspond au token
        $link = RegsiterLink::where('token', $token)->first();

        if (!$link || $user->token !== $token) {
            return redirect()->route('login.link.authenticate', ['token' => $token]);
        }

        return $next($request);
    }
}
