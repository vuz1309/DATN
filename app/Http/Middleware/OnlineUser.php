<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Cache;

class OnlineUser
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
        if (!empty(Auth::check())) {

            $expiretime = Carbon::now()->addMinutes(15);
            Cache::put('OnlineUser' . Auth::user()->id, true, $expiretime);

            $getUserInfo = User::getSingle(Auth::user()->id);
            $getUserInfo->updated_at = date('Y-m-d H:i:s');
            $getUserInfo->save();
        }
        return $next($request);
    }
}
