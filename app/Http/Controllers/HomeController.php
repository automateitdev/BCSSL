<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        // dd($request->all());
        $credentials = $request->only('email', 'password');
        // $credentials['user_type'] = User::USER_TYPE_SUPERADMIN;
        // dd(Auth::guard('admin')->attempt($credentials));
        if(Auth::guard('admin')->attempt($credentials)){
          $users = User::where('email', $request->email)->first();

          if ($users->status == USER::STATUS_ACTIVE) {
                  return redirect()->route('admin.dashboard');
          }
       }
        else{
          return back()->with('error','Wrong Login Details');
        }

        // return redirect(route('loginFail'))->with('message', 'Oppes! You have entered invalid credentials');
    }

    public function dashboard()
    {
      return view('home');
    }

    public function logout()
    {
        // dd('dd');
      if(Auth::guard('admin')->check()){
        Auth::guard('admin')->logout();
        return redirect('/login');
      }else{
        Auth::guard('web')->logout();
        return redirect('/member-portal');
      }

      return redirect('/login');
    }
    public function loginfail()
    {
      return redirect(route('login.dash'));
    }
}
