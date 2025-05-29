<?php

namespace App\Http\Controllers\Admin\CoreSetting;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Common\UserService;
use App\Services\Common\RolesService;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
    public $roleService;
    public $userService;
    public function __construct(RolesService $roleService, UserService $userService)
    {
      $this->roleService = $roleService;
      $this->userService = $userService;

      $this->middleware(['permission:Users View'])->only(['index']);
      $this->middleware(['permission:Users Add'])->only(['create','store']);
      $this->middleware(['permission:Users Edit'])->only(['edit','update']);
      $this->middleware(['permission:Users Delete'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        set_page_meta('All Admin');
        $users = $this->userService->getData()->where('email','!=',User::$seederMail[1])->sortByDesc('id')->values();
        return view('pages.admin.core-setting.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        set_page_meta('User Create');
        $user_gender = collect(User::USER_GENDER);
        $user_blood_group = collect(User::USER_BLOOD_GROUP);
        $user_status = collect(User::USER_STATUS);
        $roles = $this->roleService->getAllRoles();
        // dd($roles);
        return view('pages.admin.core-setting.user.create', compact('user_gender', 'user_blood_group', 'user_status', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        try {
            DB::beginTransaction();
            $this->userService->storeOrUpdate($data);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
            return redirect()->back();
        }
        record_created_flash('User created successfully');
        return redirect()->route('admin.users.index');
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
        set_page_meta('User Create');
        $user_gender = collect(User::USER_GENDER);
        $user_blood_group = collect(User::USER_BLOOD_GROUP);
        $user_status = collect(User::USER_STATUS);
        $roles = $this->roleService->getAllRoles();
        $user = $this->userService->get($id);
        // dd($user);
        return view('pages.admin.core-setting.user.edit', compact('user_gender', 'user_blood_group', 'user_status', 'roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();
        // dd($data);
        try {
            DB::beginTransaction();
            $this->userService->storeOrUpdate($data, $id);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
            return redirect()->back();
        }
        record_created_flash('User Updated successfully');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userService->get($id);
        if($this->userService->userDelete($user)){
            record_created_flash('User Deleted successfully');
            return redirect()->route('admin.users.index');
        }
    }
}
