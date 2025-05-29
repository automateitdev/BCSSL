<?php

namespace App\Services\Common;

use PDF;

use App\Models\User;
// use Spatie\Permission\Models\Permission;
use App\Models\Permission;
use App\Services\BaseService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Utils\FileUploadService;

class UserService extends BaseService
{

    public $roleService;
    public $fileUploadService;
    public function __construct(User $model, RolesService $roleService, FileUploadService $fileUploadService)
    {
        parent::__construct($model);
        $this->roleService = $roleService;
        $this->fileUploadService = $fileUploadService;
    }

    public function storeOrUpdate($data, $id=null){
        try {
            if($data['password'] == null){
                unset($data['password']);
            }else{
                $data['password'] = Hash::make($data['password']);
            }
            request()->isMethod('PUT') ?
            $data['updated_by'] = Auth::id()
            : $data['created_by'] = Auth::id();
            // dd($data, $id);
            //conditional wise user update or create
            $user = $this->userUpdateOrCreate($data, $id);
            // dd($user);
            if(isset($data['roles']) && !is_null($data['roles']) ){
                //user role assign
                $this->roleService->modelHasRoleAssign($user, $data['roles']) ;
            }else{
                //model exiisting roles
                $modelHasRoles =  $this->roleService->modeHasAllRoles($user) ;
                //user role delete
                if(count($modelHasRoles) > 0){
                    $this->roleService->modelRolesDetach($user) ;
                }
            }

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            //throw $th;
        }
    }

    public function userUpdateOrCreate($data, $id=null){
        $data = collect($data)->toArray();
        if(isset($data['image'])){
            $user = null;
            if(!is_null($id)){
                $user = $this->get($id);
                $old_image_path = isset($user) && !is_null($user->image) ? User::ADMIN_IMAGE.'/'.$user->image: NULL;
                // dd($old_image_path);
                $data['image'] =  $this->fileUploadService->uploadFile($data['image'], 'public/'.User::ADMIN_IMAGE,$old_image_path,null);
            }else {
                $data['image'] =  $this->fileUploadService->uploadFile($data['image'], 'public/'.User::ADMIN_IMAGE,null,null);
            }

        }

        $data['user_type'] = isset($data['user_type']) ? $data['user_type'] : 'admin';

        if(!is_null($id)){

            $email = $data['email'];
            unset($data['email']);
            $user = User::updateOrCreate(['email'=>$email],$data);
        }else{
            $user = User::create($data);
        }

        $user->fresh();
        return $user;
    }

    public function userDelete($user){
        //model exiisting roles
        $modelHasRoles =  $this->roleService->modeHasAllRoles($user) ;
        //user role delete
        if(count($modelHasRoles) > 0){
            $this->roleService->modelRolesDetach($user) ;
        }
        //old image delete
        $old_image_path = isset($user) && !is_null($user->image) ? User::ADMIN_IMAGE.'/'.$user->image: NULL;
        $this->fileUploadService->deleteFile($old_image_path);

        $user->delete();
        return true;
    }

    public function getData($id = null, $with = [])
    {
        try {
            if ($id) {
                $data = $this->model->with($with)->find($id);
                return $data ? $data : false;
            } else {
                return $this->model->with($with)->get();
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }




}
