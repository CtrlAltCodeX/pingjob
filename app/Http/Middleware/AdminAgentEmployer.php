<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminAgentEmployer
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
        if (!Auth::check()) {
            return redirect()->guest(route('login'))->with('error', trans('app.unauthorized_access'));
        }

        $user = User::find(Auth::id());

        if (!$user->is_admin() && !$user->is_employer() && !$user->is_agent())
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));



        return $next($request); //->header('Access-Control-Allow-Origin', '*')
    }
}
