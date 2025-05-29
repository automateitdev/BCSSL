<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;
use Illuminate\Http\Request;
use Auth;

class MemberCheck
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
        if(Auth::guard('web')->check()){
            $status = [Member::STATUS_ACTIVE];

            if(in_array(auth()->user()->status, $status)){
                return $next($request);
            }
            else{
                $message = "Your account is ".auth()->user()->status;
                Auth::logout();
                return redirect(route('member.portal'))->with('error', $message);
            }

        }

        return redirect()->route('member.portal');

    }
}
