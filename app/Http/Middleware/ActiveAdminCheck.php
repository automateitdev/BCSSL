<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveAdminCheck
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

        if(Auth::guard('admin')->check()){
            $status = [User::STATUS_ACTIVE];
            $user_type = [User::USER_TYPE_SUPERADMIN];
            if(!in_array(auth()->user()->status, $status)){
                return redirect()->route('member.portal');
            }
            // if(!in_array(auth()->user()->user_type, $user_type)){
            //     return redirect()->route('member.portal');
            // }
        }
        return $next($request);
    }
}
