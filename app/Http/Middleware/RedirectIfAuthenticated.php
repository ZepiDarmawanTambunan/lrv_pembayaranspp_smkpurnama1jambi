<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = auth()->user();
                if ($user->akses == 'operator' || $user->akses == 'admin') {
                    return redirect()->route('operator.beranda');
                } elseif ($user->akses == 'wali') {
                    return redirect()->route('wali.beranda');
                } else {
                    Auth::logout();
                    flash('Anda tidak memiliki hak akses')->error();
                    return redirect()->route('login');
                }
            }
        }

        return $next($request);
    }
}
