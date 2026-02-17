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
    public function handle($request, Closure $next, ...$guards)
{
    if (auth()->check()) {
        $role = auth()->user()->role->name;

        return match ($role) {
            'admin' => redirect('/admin/dashboard'),
            'hrd' => redirect('/hrd/dashboard'),
            'finance' => redirect('/finance/dashboard'),
            default => redirect('/karyawan/dashboard'),
        };
    }

    return $next($request);
 }
 
}
