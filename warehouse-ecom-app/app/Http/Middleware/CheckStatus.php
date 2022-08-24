<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $verify_status = DB::table('app_user_roles')
        ->where('status', '!=', 'Inctive')
        ->where('email', '=', Auth::user()->email)
        ->count();
        if ($verify_status === 1) {
            return $next($request);
        }
        return response()->view('errors.403');

    }
}
