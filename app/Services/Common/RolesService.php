<?php

namespace App\Services\Common;

use PDF;

use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use App\Models\Permission;
use App\Services\BaseService;

class RolesService extends BaseService
{


    public function __construct()
    {

    }


    public function getAllRoles(){
        return Role::all();
    }

    public  function findRoleByIdGardName($id ,$guardName){
        if(empty($guardName)){
            return $role = Role::findById($id,'admin');
        }
        return $role = Role::findById($id,$guardName);
    }

    public function getAllPermissions(){
        return Permission::with('children.children')
        ->where('parent_id', null)
        ->get();
    }

    public function roleHasPermissions($role, $permissions){
        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }

    }

    public function modelHasRoleAssign($user, $role){
        $user->syncRoles($role);
    }

    public function modeHasAllRoles($user){
        return $user->roles;
    }

    public function modelRolesDetach($user){
        //user assign role delete
        $user->roles()->detach();
    }




}
