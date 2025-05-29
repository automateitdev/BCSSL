<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class MemberAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        Session::put('navtab', $request->nav_tab);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'f_name' => 'required',
            'm_name' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'nationality' => 'nullable',
            'nid' => 'nullable',
            'blood_grp' => 'nullable',
            'mobile' => 'required',
            'image' => 'required',
            'present_address' => 'required',
            'present_thana' => 'nullable',
            'present_district' => 'nullable',
            'present_division' => 'nullable',
            'permanent_address' => 'required',
            'permanent_thana' => 'nullable',
            'permanent_district' => 'nullable',
            'permanent_division' => 'nullable'
        ]);

        $input = new User();
        $input->name = $request->name;
        $input->email = $request->email;
        $input->password = Hash::make($request->password);
        $input->f_name = $request->f_name;
        $input->m_name = $request->m_name;
        $input->birth_date = $request->birth_date;
        $input->gender = $request->gender;
        $input->marital_status = $request->marital_status;
        $input->religion = $request->religion;
        $input->nationality = $request->nationality;
        $input->nid = $request->nid;
        $input->blood_grp = $request->blood_grp;
        $input->mobile = $request->mobile;
        $input->present_address = $request->present_address;
        $input->present_thana = $request->present_thana;
        $input->present_district = $request->present_district;
        $input->present_division = $request->present_division;
        $input->permanent_address = $request->permanent_address;
        $input->permanent_thana = $request->permanent_thana;
        $input->permanent_district = $request->permanent_district;
        $input->permanent_division = $request->permanent_division;
        $input->role = '3';

        if($request->file('image')){

            $allowedfileExtension = ['jpeg', 'jpg', 'png'];
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $check = in_array($extension, $allowedfileExtension);
            if ($check) {
                $file->move('files/images',$filename);
            }
            else{
                return redirect(route('member.portal'))->with('error', "Image must be jpeg, jpg or png format.");
            }
            $input->image = $filename;
        }else{
            $input->image = '';
        }

        $input->save();
        return redirect(route('member.portal'))->with('message', "Successfull, waiting for approved");

    }

    public function member_auth(Request $request)
    {
        Session::put('navtab', $request->nav_tab);
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
          $users = User::where('email', $request->email)->first();

          if ($users->roll == 3) {
                return redirect(route('member.portal'))->with('message', "Admin not approved your account yet.");
          }elseif($users->roll == 0)
          {
                return redirect(route('member.portal'))->with('message', "Your Account is suspended.");
          }elseif($users->roll == 2){
                return redirect(route('member_dashboard'));
          }
       }
        else{
          return back()->with('error','Wrong Login Details');
        }

        return redirect('loginFail')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function member_dashboard(){
        return view('layouts.member.dashboard');
    }

    public function mem_logout()
    {
      Auth::logout();

      return redirect('/member-portal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
