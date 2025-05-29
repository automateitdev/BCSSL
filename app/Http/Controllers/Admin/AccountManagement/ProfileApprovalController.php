<?php

namespace App\Http\Controllers\Admin\AccountManagement;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Nominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MemberProfileUpdate;
use App\Http\Controllers\Controller;
use App\Models\Distict;
use App\Models\MemberChoice;
use App\Models\MemberChoiceUpdate;
use App\Services\Utils\FileUploadService;

class ProfileApprovalController extends Controller
{
    public $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;

        $this->middleware(['permission:Profile Update View'])->only(['updatedProfilesList']);
        $this->middleware(['permission:Profile Update Edit'])->only(['updatedProfilesSubmit','updatedProfilesView']);

    }
    public function updatedProfilesList(){
        set_page_meta('Update Profile List');
        $memberUpdateProfiles = MemberProfileUpdate::query()->select(['id','member_id','created_at'])
        ->with(['member:id,name,email,gender,mobile,created_at'])
        ->where('status',MemberProfileUpdate::STATUS_PENDING)
        ->latest()->get();
        // return $memberUpdateProfiles;
        // dd($memberUpdateProfiles);
        return view('pages.admin.account_mamagement.update.update-profiles-list',compact('memberUpdateProfiles'));

    }

    public function updatedProfilesView($id){
        $memberUpdateProfiles = MemberProfileUpdate::query()
        ->with(['member.nominee'])
        ->latest()->find($id);
        $all_status = MemberProfileUpdate::ALL_STATUS;
        // $MemberChoiceUpdates = MemberChoiceUpdate::query()->where('member_id',$memberUpdateProfiles->member->id)->get();

        $member = Member::query()->with(['memberChoices','memberChoicesUpdate'])->find($memberUpdateProfiles->member->id);
        // dd($member);
        $disticts = Distict::query()->get();
        set_page_meta(ucfirst($memberUpdateProfiles->member->name).' Profile Update View');
        return view('pages.admin.account_mamagement.update.update-profile-view',compact('memberUpdateProfiles','all_status','member','disticts'));

    }
    public function memberProfieUpdateImageDelete($id){
        $memberUpdateProfile = MemberProfileUpdate::query()->find($id);
        if(!is_null($memberUpdateProfile->image)){
            $old_image_path = 'storage/'.Member::APPLICENT_IMAGE.'/'.$memberUpdateProfile->image;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->nid_back)){
            $old_image_path = 'storage/'.Member::APPLICENT_NID.'/'.$memberUpdateProfile->nid_back;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->nid_front)){
            $old_image_path = 'storage/'.Member::APPLICENT_NID.'/'.$memberUpdateProfile->nid_front;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->signature)){
            $old_image_path = 'storage/'.Member::APPLICENT_SIGNATURE.'/'.$memberUpdateProfile->signature;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->proof_joining_cadre)){
            $old_image_path = 'storage/'.Member::JOIN_PROOF.'/'.$memberUpdateProfile->proof_joining_cadre;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->proof_signed_by_sup_author)){
            $old_image_path = 'storage/'.Member::JOIN_PROOF.'/'.$memberUpdateProfile->proof_signed_by_sup_author;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->nominee_image)){
            $old_image_path = 'storage/'.Member::NOMINEE_IMAGE.'/'.$memberUpdateProfile->nominee_image;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->nominee_nid_back)){
            $old_image_path = 'storage/'.Member::NOMINEE_NID.'/'.$memberUpdateProfile->nominee_nid_back;
            $this->fileUploadService->delete($old_image_path);
        }
        if(!is_null($memberUpdateProfile->nominee_nid_front)){
            $old_image_path = 'storage/'.Member::NOMINEE_NID.'/'.$memberUpdateProfile->nominee_nid_front;
            $this->fileUploadService->delete($old_image_path);
        }
    }
    public function updatedProfilesSubmit(Request $request){

        try {
            DB::beginTransaction();
            $memberUpdateProfiles = MemberProfileUpdate::query()
            ->with(['member'])->find($request->id);
            $newDateTime = Carbon::now()->addDay(2);
            // $newDateTime = Carbon::now()->addDay(2)->toDateTimeString();
            if($request->status ==  MemberProfileUpdate::STATUS_INAPPROVE){
                $this->memberProfieUpdateImageDelete($request->id);
                $memberUpdateProfiles->update([
                    'status'=>MemberProfileUpdate::STATUS_INAPPROVE,
                    'alert_notify' => $newDateTime
                ]);
            }
            else  if($request->status ==  MemberProfileUpdate::STATUS_PENDING){
                $memberUpdateProfiles->update([
                    'status'=>MemberProfileUpdate::STATUS_PENDING,
                    'alert_notify' => $newDateTime
                ]);
            }else{

                $memberUpdateProfiles->update([
                    'status'=>MemberProfileUpdate::STATUS_APPROVE,
                    'alert_notify' => $newDateTime
                ]);
                $member = Member::find($memberUpdateProfiles->member_id)->load(['nominee','memberChoices','memberChoicesUpdate']);

                if(!is_null($memberUpdateProfiles->name)){
                    $member->name = $memberUpdateProfiles->name;
                }
                if(!is_null($memberUpdateProfiles->father_name)){
                    $member->father_name = $memberUpdateProfiles->father_name;
                }
                if(!is_null($memberUpdateProfiles->mother_name)){
                    $member->mother_name = $memberUpdateProfiles->mother_name;
                }
                if(!is_null($memberUpdateProfiles->image)){
                    $old_image_path = 'storage/'.Member::APPLICENT_IMAGE.'/'.$member->image ;
                    $this->fileUploadService->delete($old_image_path);

                    $member->image = $memberUpdateProfiles->image;

                }
                if(!is_null($memberUpdateProfiles->spouse_name)){
                    $member->spouse_name = $memberUpdateProfiles->spouse_name;
                }
                if(!is_null($memberUpdateProfiles->bcs_batch)){
                    $member->bcs_batch = $memberUpdateProfiles->bcs_batch;
                }
                if(!is_null($memberUpdateProfiles->joining_date)){
                    $member->joining_date = $memberUpdateProfiles->joining_date;
                }
                if(!is_null($memberUpdateProfiles->cader_id)){
                    $member->cader_id = $memberUpdateProfiles->cader_id;
                }
                if(!is_null($memberUpdateProfiles->birth_date)){
                    $member->birth_date = $memberUpdateProfiles->birth_date;
                }
                if(!is_null($memberUpdateProfiles->gender)){
                    $member->gender = $memberUpdateProfiles->gender;
                }
                if(!is_null($memberUpdateProfiles->mobile)){
                    $member->mobile = $memberUpdateProfiles->mobile;
                }
                if(!is_null($memberUpdateProfiles->formatted_number)){
                    $member->formatted_number = $memberUpdateProfiles->formatted_number;
                }
                if(!is_null($memberUpdateProfiles->country_code)){
                    $member->country_code = $memberUpdateProfiles->country_code;
                }
                if(!is_null($memberUpdateProfiles->email)){
                    $member->email = $memberUpdateProfiles->email;
                }
                if(!is_null($memberUpdateProfiles->password)){
                    $member->password = $memberUpdateProfiles->password;
                }
                if(!is_null($memberUpdateProfiles->office_address)){
                    $member->office_address = $memberUpdateProfiles->office_address;
                }
                if(!is_null($memberUpdateProfiles->nid)){
                    $member->nid = $memberUpdateProfiles->nid;
                }
                if(!is_null($memberUpdateProfiles->nid_front)){

                    $old_image_path = 'storage/'.Member::APPLICENT_NID.'/'.$member->nid_front ;
                    $this->fileUploadService->delete($old_image_path);

                    $member->nid_front = $memberUpdateProfiles->nid_front;
                }
                if(!is_null($memberUpdateProfiles->nid_back)){

                    $old_image_path = 'storage/'.Member::APPLICENT_NID.'/'.$member->nid_back ;
                    $this->fileUploadService->delete($old_image_path);

                    $member->nid_back = $memberUpdateProfiles->nid_back;
                }
                if(!is_null($memberUpdateProfiles->signature)){

                    $old_image_path = 'storage/'.Member::APPLICENT_SIGNATURE.'/'.$member->signature ;
                    $this->fileUploadService->delete($old_image_path);

                    $member->signature = $memberUpdateProfiles->signature;
                }
                if(!is_null($memberUpdateProfiles->proof_joining_cadre)){
                    $member->proof_joining_cadre = $memberUpdateProfiles->proof_joining_cadre;
                }
                if(!is_null($memberUpdateProfiles->proof_signed_by_sup_author)){
                    $member->proof_signed_by_sup_author = $memberUpdateProfiles->proof_signed_by_sup_author;
                }
                if(!is_null($memberUpdateProfiles->present_address)){
                    $member->present_address = $memberUpdateProfiles->present_address;
                }
                if(!is_null($memberUpdateProfiles->permanent_address)){
                    $member->permanent_address = $memberUpdateProfiles->permanent_address;
                }
                if(!is_null($memberUpdateProfiles->emergency_contact)){
                    $member->emergency_contact = $memberUpdateProfiles->emergency_contact;
                }
                if(!is_null($memberUpdateProfiles->ref_name)){
                    $member->ref_name = $memberUpdateProfiles->ref_name;
                }
                if(!is_null($memberUpdateProfiles->ref_mobile)){
                    $member->ref_mobile = $memberUpdateProfiles->ref_mobile;
                }
                if(!is_null($memberUpdateProfiles->ref_memeber_id_no)){
                    $member->ref_memeber_id_no = $memberUpdateProfiles->ref_memeber_id_no;
                }
                $member->save();

                $nominee_data = Nominee::find($member->nominee->id);
                if(!is_null($memberUpdateProfiles->nominee_name)){
                    $nominee_data->name = $memberUpdateProfiles->nominee_name;
                }
                if(!is_null($memberUpdateProfiles->nominee_father_name)){
                    $nominee_data->father_name = $memberUpdateProfiles->nominee_father_name;
                }
                if(!is_null($memberUpdateProfiles->nominee_mother_name)){
                    $nominee_data->mother_name = $memberUpdateProfiles->nominee_mother_name;
                }
                if(!is_null($memberUpdateProfiles->nominee_image)){

                    $old_image_path = 'storage/'.Member::APPLICENT_IMAGE.'/'.   $nominee_data->image ;
                    $this->fileUploadService->delete($old_image_path);

                    $nominee_data->image = $memberUpdateProfiles->nominee_image;
                }
                if(!is_null($memberUpdateProfiles->nominee_birth_date)){
                    $nominee_data->birth_date = $memberUpdateProfiles->nominee_birth_date;
                }
                if(!is_null($memberUpdateProfiles->nominee_gender)){
                    $nominee_data->gender = $memberUpdateProfiles->nominee_gender;
                }


                if(!is_null($memberUpdateProfiles->nominee_mobile)){
                    $nominee_data->mobile = $memberUpdateProfiles->nominee_mobile;
                }
                if(!is_null($memberUpdateProfiles->nominee_formatted_number)){
                    $nominee_data->formatted_number = $memberUpdateProfiles->nominee_formatted_number;
                }
                if(!is_null($memberUpdateProfiles->nominee_country_code)){
                    $nominee_data->country_code = $memberUpdateProfiles->nominee_country_code;
                }


                if(!is_null($memberUpdateProfiles->nominee_relation_with_user)){
                    $nominee_data->relation_with_user = $memberUpdateProfiles->nominee_relation_with_user;
                }
                if(!is_null($memberUpdateProfiles->nominee_nid)){


                    $nominee_data->nid = $memberUpdateProfiles->nominee_nid;
                }
                if(!is_null($memberUpdateProfiles->nominee_nid_front)){


                    $old_image_path = 'storage/'.Member::NOMINEE_NID.'/'.   $nominee_data->nid_front ;
                    $this->fileUploadService->delete($old_image_path);

                    $nominee_data->nid_front = $memberUpdateProfiles->nominee_nid_front;
                }
                if(!is_null($memberUpdateProfiles->nominee_nid_back)){

                    $old_image_path = 'storage/'.Member::NOMINEE_NID.'/'.   $nominee_data->nid_back ;
                    $this->fileUploadService->delete($old_image_path);

                    $nominee_data->nid_back = $memberUpdateProfiles->nominee_nid_back;
                }
                if(!is_null($memberUpdateProfiles->nominee_professional_details)){
                    $nominee_data->professional_details = $memberUpdateProfiles->nominee_professional_details;
                }
                if(!is_null($memberUpdateProfiles->nominee_permanent_address)){
                    $nominee_data->permanent_address = $memberUpdateProfiles->nominee_permanent_address;
                }
                $nominee_data->save();

                //member choice is change check....
                $member_choice_count = 0;
                if(count($member->memberChoicesUpdate) > 0){
                    foreach($member->memberChoicesUpdate as $memberChoiceUpdate){
                        $db_member_choice = $member->memberChoices->where('project_type',$memberChoiceUpdate->project_type)->first();
                        if(!is_null($db_member_choice)){
                            if($db_member_choice->capacity_range != $memberChoiceUpdate->capacity_range ) $member_choice_count++;
                            if($db_member_choice->flat_size != $memberChoiceUpdate->flat_size ) $member_choice_count++;
                            if($db_member_choice->exp_bank_loan != $memberChoiceUpdate->exp_bank_loan ) $member_choice_count++;
                            if($db_member_choice->num_flat_shares != $memberChoiceUpdate->num_flat_shares ) $member_choice_count++;
                            if($db_member_choice->p_introducer_name != $memberChoiceUpdate->p_introducer_name ) $member_choice_count++;
                            if($db_member_choice->p_introducer_member_num != $memberChoiceUpdate->p_introducer_member_num ) $member_choice_count++;
                            if(count($db_member_choice->prefered_area) != count($memberChoiceUpdate->prefered_area))$member_choice_count++;
                        }else{
                            $member_choice_count++;
                        }

                    }
                }
                //member choice new data created
                if(count($member->memberChoicesUpdate) > 0){
                    //old member choice delete
                    $member->memberChoices()->delete();
                    foreach($member->memberChoicesUpdate as $memberChoiceUpdate){

                        MemberChoice::create([
                            'member_id' => $member->id,
                            'pref_of_dcc' => isset($memberChoiceUpdate->pref_of_dcc) ?$memberChoiceUpdate->pref_of_dcc : null,
                            'pref_close_dcc' => isset($memberChoiceUpdate->pref_close_dcc) ?$memberChoiceUpdate->pref_close_dcc : null,
                            'flat_size' => isset($memberChoiceUpdate->flat_size) ?$memberChoiceUpdate->flat_size : null,
                            'exp_bank_loan' => isset($memberChoiceUpdate->exp_bank_loan) ?$memberChoiceUpdate->exp_bank_loan : null,
                            'num_flat_shares' => isset($memberChoiceUpdate->num_flat_shares) ?$memberChoiceUpdate->num_flat_shares : null,
                            'capacity_range' =>isset($memberChoiceUpdate->capacity_range) ?$memberChoiceUpdate->capacity_range : null,
                            'distict_pref' => isset($memberChoiceUpdate->distict_pref) ?$memberChoiceUpdate->distict_pref : null,
                            'prefered_area' =>isset($memberChoiceUpdate->prefered_area) ?$memberChoiceUpdate->prefered_area : null,
                            'project_type' => isset($memberChoiceUpdate->project_type) ?$memberChoiceUpdate->project_type : null,
                            'p_introducer_name' => isset($memberChoiceUpdate->p_introducer_name) ?$memberChoiceUpdate->p_introducer_name : null,
                            'p_introducer_member_num' => isset($memberChoiceUpdate->p_introducer_member_num) ?$memberChoiceUpdate->p_introducer_member_num : null,
                        ]);
                    }

                }


            }
            record_created_flash(ucfirst($request->status).'  Sucessfully');
            DB::commit();
            return redirect()->route('admin.updated.profiles.list');
        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
            //throw $th;
        }


    }
}
