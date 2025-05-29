<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\Common\RolesService;

class RoleController extends Controller
{
    public $roleService;
    public function __construct(RolesService $roleService)
    {
      $this->roleService = $roleService;
      $this->middleware(['permission:Roles View'])->only(['index']);
      $this->middleware(['permission:Roles Add'])->only(['create','store']);
      $this->middleware(['permission:Roles Edit'])->only(['edit','update']);
      $this->middleware(['permission:Roles Delete'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        set_page_meta('All Roles');
        $roles = Role::all();
        // dd($roles);
        return view('pages.admin.role-permission.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        set_page_meta('Create Roles');
        $permissions = Permission::with('children.children')
        ->where('parent_id', null)
        ->get();
        // dd($permissions);
        return view('pages.admin.role-permission.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //validaton create
         $request->validate([
            'name' => 'required|unique:roles'
        ]);
        try {
            DB::beginTransaction();
            $role = Role::create([
                'name' => $request->name,
                'guard_name'=>'admin'
            ]);
            $permissions = $request->permissions;
            if(!empty($permissions)){
                $this->roleService->roleHasPermissions($role, $permissions);
                // $role->syncPermissions($permissions);
            }
            DB::commit();
            record_created_flash('Role created successfully');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
        }

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
        set_page_meta('Edit Roles');
        $role = $this->roleService->findRoleByIdGardName($id,'admin');

        $permissions = $this->roleService->getAllPermissions();
        // dd($permissions);
        return view('pages.admin.role-permission.edit', compact('permissions','role'));

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
        $request->validate([
            'name' => ['required', 'unique:roles,name,'.$id],
        ]);
        try {
            DB::beginTransaction();
            $role =  $this->roleService->findRoleByIdGardName($id,'admin');
            $permissions = $request->permissions;
            if(!is_null($role)){
                $role->update(['name'=>$request->name]);
            }
            if(!empty($permissions)){
                $this->roleService->roleHasPermissions($role, $permissions);
            }
            DB::commit();
            record_created_flash('Role Update successfully');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role =  $this->roleService->findRoleByIdGardName($id,'admin');
            if($role->delete()){
                record_created_flash('Role Deleted successfully');
                return redirect()->route('admin.roles.index');
            }

        } catch (\Exception $e) {
            something_wrong_flash($e->getMessage());
        }

    }
}
