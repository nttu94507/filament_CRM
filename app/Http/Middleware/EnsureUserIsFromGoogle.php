<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsFromGoogle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('admin');

        if (! $guard->check()) {
            return redirect()->guest(route('filament.admin.auth.login'));
        }

        if (session('provider') !== 'google') {
            abort(403, '請使用 Google 登入才能存取這個頁面。');
        }

        $user = $guard->user();

        if (session('login_provider') !== 'google') {
            abort(403, '請使用 Google 登入');
        }

        return $next($request);
    }
}
