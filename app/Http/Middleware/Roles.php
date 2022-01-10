<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Roles
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check())
            return redirect()->route('guest.home.index');

        $user = Auth::user();

        foreach ($roles as $role) {

            if ($user->role->name == $role)
                return $next($request);
        }

        return redirect()->route('authentication.login.index');
    }
}
