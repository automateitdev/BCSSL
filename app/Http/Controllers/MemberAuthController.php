<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\Nominee;
use App\Models\MemberChoice;
use Illuminate\Http\Request;
use App\Models\AssociatorsInfo;
use App\Models\MemberChoiceUpdate;
use Illuminate\Support\Facades\DB;
use App\Models\MemberProfileUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\Utils\FileUploadService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MemberAuthController extends Controller
{
    public $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
        // memberProfileUpdate
        $this->middleware('auth:web')->only(['memberProfileUpdate']);
    }
    public function index()
    {
        $user_gender = collect(User::USER_GENDER);
        $user_blood_group = collect(User::USER_BLOOD_GROUP);
        return view('pages.member.member_login_register', [
            'user_gender' => $user_gender,
            'user_blood_group' => $user_blood_group
        ]);
    }

    public function applicantInfoValiation($applicant_info_data)
    {
        return Validator::make($applicant_info_data, [
            'name' => 'required|max:255',
            'father_name' => 'required|max:255',
            'mother_name' => 'required|max:255',
            'spouse_name' => 'nullable|max:255',
            'image' => request()->isMethod('post') ? 'required' : 'nullable',

            'birth_date' => 'required|date',
            'gender' => 'required|in:other,male,female',
            'mobile' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => request()->isMethod('post') ? 'required|min:6' : 'nullable',
            'nid' => 'required',
            'nid_front' =>  request()->isMethod('post') ? 'required' : 'nullable',
            'nid_back' =>  request()->isMethod('post') ? 'required' : 'nullable',

            'present_address' => 'nullable',
            'permanent_address' => 'nullable',
            'emergency_contact' => 'nullable',

            'current_occupation' => 'required',
            'current_designation' => 'required',
            'current_occupation_joining' => 'required|date',
            'current_office_address' => 'nullable',

            'ref_name' => 'nullable',
            'ref_mobile' => 'nullable',
            'ref_memeber_id_no' => 'nullable',
        ]);
    }
    public function nomineeInfoValidation($nominee_info_data)
    {
        return Validator::make($nominee_info_data, [
            'name' => 'required|max:255',
            'father_name' => 'required|max:255',
            'mother_name' => 'required|max:255',

            'image' =>  request()->isMethod('post') ? 'required' : 'nullable',
            'birth_date' => 'required|date',
            'gender' => 'required|in:other,male,female',
            'email' => 'nullable|email:rfc,dns',
            'mobile' => 'required',
            'relation_with_user' => 'required',
            'permanent_address' => 'required',
            'professional_details' => 'nullable',
            'nid' => 'required',
            'nid_front' =>  request()->isMethod('post') ? 'required' : 'nullable',
            'nid_back' =>  request()->isMethod('post') ? 'required' : 'nullable',

        ], [
            'name.required' => 'Nominee :attribute is required',
            'name.max' => 'The Nominee :attribute must not be greater than 1 characters.',
            'father_name.required' => 'Nominee :attribute is required',
            'father_name.max' => 'The Nominee :attribute must not be greater than 1 characters.',
            'mother_name.required' => 'Nominee :attribute is required',
            'mother_name.max' => 'The Nominee :attribute must not be greater than 1 characters.',
            'image.required' => 'Nominee :attribute is required',
            'birth_date.required' => 'Nominee :attribute is required',
            'gender.required' => 'Nominee :attribute is required',
            'gender.required' => 'Nominee :attribute is required',
            'relation_with_user.required' => 'Nominee :attribute is required',
            'permanent_address.required' => 'Nominee :attribute is required',
            'nid.required' => 'Nominee :attribute is required',
            'nid_front.required' => 'Nominee :attribute is required',
            'nid_back.required' => 'Nominee :attribute is required',
        ]);
    }




    public function memberRegister(Request $request)
    {
        // return $request->all();
        // Log::info($request->all());
        // dd(Auth::guard('admin')->check());
        $applicant_info_data = collect($request->applicant_info)->toArray();
        $nominee_info_data = collect($request->nominee_info)->toArray();
        $member_choice_data = $request->member_choice;

        //backend validaiton
        // Retrieve the validated input...
        $approval_validated = $this->applicantInfoValiation($applicant_info_data)->validated();
        $nominee_validated = $this->nomineeInfoValidation($nominee_info_data)->validated();

        try {
            DB::beginTransaction();
            if (isset($applicant_info_data['image']) && $applicant_info_data['image'] != null) {
                $applicant_info_data['image'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['image'], Member::APPLICENT_IMAGE);
            }
            if (isset($applicant_info_data['nid_back']) && $applicant_info_data['nid_back'] != null) {
                $applicant_info_data['nid_back'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['nid_back'], Member::APPLICENT_NID);
            }
            if (isset($applicant_info_data['nid_front']) && $applicant_info_data['nid_front'] != null) {
                $applicant_info_data['nid_front'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['nid_front'], Member::APPLICENT_NID);
            }
            if (isset($applicant_info_data['signature']) && $applicant_info_data['signature'] != null) {
                $applicant_info_data['signature'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['signature'], Member::APPLICENT_SIGNATURE);
            }

            if (isset($applicant_info_data['proof_signed_by_sup_author']) && $applicant_info_data['proof_signed_by_sup_author'] != null) {
                $applicant_info_data['proof_signed_by_sup_author'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['proof_signed_by_sup_author'], Member::SUP_AUTH_PROOF);
            }
            $applicant_info_data['password'] = Hash::make($applicant_info_data['password']);
            $applicant_info_data['mobile'] = $applicant_info_data['mobile'];
            $applicant_info_data['formatted_number'] = $applicant_info_data['formattedNumber'];
            $applicant_info_data['country_code'] = $applicant_info_data['country_code'];

            $user = Member::create($applicant_info_data);
            if (Auth::guard('admin')->check()) {
                $this->forAdminRegister($user);
            }

            if (!is_null($user)) {
                //nomine created
                if (isset($nominee_info_data['image']) && $nominee_info_data['image'] != null) {
                    $nominee_info_data['image'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['image'], Member::NOMINEE_IMAGE);
                }
                if (isset($nominee_info_data['nid_back']) && $nominee_info_data['nid_back'] != null) {
                    $nominee_info_data['nid_back'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['nid_back'], Member::NOMINEE_NID);
                }
                if (isset($nominee_info_data['nid_front']) && $nominee_info_data['nid_front'] != null) {
                    $nominee_info_data['nid_front'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['nid_front'], Member::NOMINEE_NID);
                }
                $nominee_info_data['member_id'] = $user->id;

                $nominee_info_data['formatted_number'] = $nominee_info_data['formattedNumber'];
                $nominee_info_data['country_code'] = $nominee_info_data['country_code'];
                Nominee::create($nominee_info_data);

                // return $member_choice_data['exp_bank_loan'][0]['name'];

                //member choice creted
                foreach ($member_choice_data as $member_choice) {
                    $member_choice['member_id'] =  $user->id;
                    MemberChoice::create($member_choice);
                }

                DB::commit();
                if (Auth::guard('admin')->check()) {
                    record_created_flash('Profile created successfully');
                } else {
                    record_created_flash('Successfull, waiting for approved');
                }

                return response()->json([
                    'status' => 'success'
                ]);
            }
        } catch (\Exception $th) {
            DB::rollBack();
            // dd($th->getMessage());
            Log::error('Member Registration Error: ' . ['error' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function forAdminRegister($user)
    {
        $member = Member::find($user->id);
        $member->status = Member::STATUS_ACTIVE;
        if ($member->save()) {
            AssociatorsInfo::create([
                'member_id' => $user->id,
                'created_at' =>  Carbon::now()
            ]);
        }
        // status will be active and association in fo creaed
    }

    protected function credentials(Request $request)
    {
        // dd(is_numeric($request->get('email')));
        if (is_numeric($request->get('email'))) {
            return ['mobile' => substr($request->get('email'), 1), 'password' => $request->get('password')];
        } else if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password')];
        }
    }

    public function memberLogin(Request $request)
    {
        Session::put('navtab', $request->nav_tab);
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $this->credentials($request);

        // dd($credentials);
        // $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            if (is_numeric($request->get('email'))) {
                $users = Member::where('mobile', substr($request->get('email'), 1))->first();
            } else {
                $users = Member::where('email', $request->get('email'))->first();
            }

            if ($users->status == Member::STATUS_INACTIVE) {
                return redirect(route('member.portal'))->with('message', "Admin not approved your account yet.");
            } elseif ($users->status == Member::STATUS_SUSPENDED) {
                return redirect(route('member.portal'))->with('message', "Your Account is suspended.");
            } else {
                return redirect(route('member.memberInfo'));
            }
        } else {
            return back()->with('error', 'Wrong Login Details');
        }

        return redirect('loginFail')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function memberUpdate(Request $request, $id)
    {
        $applicant_info_data = collect($request->applicant_info)->toArray();
        $nominee_info_data = collect($request->nominee_info)->toArray();
        $member_choice_data = $request->member_choice;

        //backend validaiton
        // Retrieve the validated input...
        $approval_validated = $this->applicantInfoValiation($applicant_info_data)->validated();
        $nominee_validated = $this->nomineeInfoValidation($nominee_info_data)->validated();

        $member = Member::find($id)->load(['nominee', 'associatorsInfo', 'memberChoices']);

        if (isset($applicant_info_data['password']) && $applicant_info_data['password'] != null) {
            $applicant_info_data['password'] = Hash::make($applicant_info_data['password']);
        }

        try {
            DB::beginTransaction();

            if (isset($applicant_info_data['image']) && $applicant_info_data['image'] != null) {
                $old_image_path = isset($member) && !is_null($member->image) ? 'storage/' . Member::APPLICENT_IMAGE . '/' . $member->image : NULL;
                $applicant_info_data['image'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['image'], Member::APPLICENT_IMAGE, null, $old_image_path);
            } else {
                $applicant_info_data['image'] = $member->image;
            }

            if (isset($applicant_info_data['nid_back']) && $applicant_info_data['nid_back'] != null) {
                $old_image_path =  isset($member) && !is_null($member->nid_back) ?  'storage/' . Member::APPLICENT_NID . '/' . $member->nid_back : NULL;
                $applicant_info_data['nid_back'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['nid_back'], Member::APPLICENT_NID, null, $old_image_path);
            } else {
                $applicant_info_data['nid_back'] = $member->nid_back;
            }
            if (isset($applicant_info_data['nid_front']) && $applicant_info_data['nid_front'] != null) {
                $old_image_path = isset($member) && !is_null($member->nid_front) ?   'storage/' . Member::APPLICENT_NID . '/' . $member->nid_front : NULL;
                $applicant_info_data['nid_front'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['nid_front'], Member::APPLICENT_NID, null, $old_image_path);
            } else {
                $applicant_info_data['nid_front'] = $member->nid_front;
            }
            if (isset($applicant_info_data['signature']) && $applicant_info_data['signature'] != null) {
                $old_image_path = isset($member) && !is_null($member->signature) ?  'storage/' . Member::APPLICENT_SIGNATURE . '/' . $member->signature : NULL;
                $applicant_info_data['signature'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['signature'], Member::APPLICENT_SIGNATURE, null, $old_image_path);
            } else {
                $applicant_info_data['signature'] = $member->signature;
            }


            // $applicant_info_data['mobile'] = $applicant_info_data['formattedNumber'];

            $applicant_info_data['formatted_number'] = $applicant_info_data['formattedNumber'];
            $applicant_info_data['country_code'] = $applicant_info_data['country_code'];

            //nominee image update
            //nomine created
            if (isset($nominee_info_data['image']) && $nominee_info_data['image'] != null) {
                $old_image_path =  isset($member->nominee) && !is_null($member->nominee->image) ?  'storage/' . Member::NOMINEE_IMAGE . '/' . $member->nominee->image : NULL;
                $nominee_info_data['image'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['image'], Member::NOMINEE_IMAGE, null, $old_image_path);
            } else {
                $nominee_info_data['image'] = $member->nominee->image;
            }
            if (isset($nominee_info_data['nid_back']) && $nominee_info_data['nid_back'] != null) {
                $old_image_path = isset($member->nominee) && !is_null($member->nominee->nid_back) ?  'storage/' . Member::NOMINEE_NID . '/' . $member->nominee->nid_back : NULL;
                $nominee_info_data['nid_back'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['nid_back'], Member::NOMINEE_NID, null, $old_image_path);
            } else {
                $nominee_info_data['nid_back'] = $member->nominee->nid_back;
            }
            if (isset($nominee_info_data['nid_front']) && $nominee_info_data['nid_front'] != null) {
                $old_image_path = isset($member->nominee) && !is_null($member->nominee->nid_front) ?  'storage/' . Member::NOMINEE_NID . '/' . $member->nominee->nid_front : NULL;
                $nominee_info_data['nid_front'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['nid_front'], Member::NOMINEE_NID, null, $old_image_path);
            } else {
                $nominee_info_data['nid_front'] = $member->nominee->nid_front;
            }
            // $nominee_info_data['mobile'] = $nominee_info_data['formattedNumber'] ?? '';

            $nominee_info_data['formatted_number'] = $nominee_info_data['formattedNumber'];
            $nominee_info_data['country_code'] = $nominee_info_data['country_code'];

            //unset unused data
            unset($applicant_info_data['bc_image']);
            unset($applicant_info_data['bc_nid_back']);
            unset($applicant_info_data['bc_nid_front']);
            unset($applicant_info_data['formattedNumber']);
            unset($applicant_info_data['bc_signature']);
            unset($nominee_info_data['bc_image']);
            unset($nominee_info_data['bc_nid_back']);
            unset($nominee_info_data['bc_nid_front']);
            unset($nominee_info_data['formattedNumber']);
            //member update
            $member = $member->updateOrCreate(
                ['id' => $id],
                $applicant_info_data
            );

            $member->nominee()->update(
                $nominee_info_data
            );

            if (!is_null($member->memberChoices)) {
                $member->memberChoices()->delete();

                //member choice creted
                foreach ($member_choice_data as $member_choice) {
                    $member_choice['member_id'] =  $member->id;
                    MemberChoice::create($member_choice);
                }
            }
            DB::commit();
            record_created_flash('Profile Updated successfully');
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            something_wrong_flash($th->getMessage());
            // dd($th->getMessage());
            return response()->json([
                'status' => 'error',
                'errpr' => $th->getMessage()
            ]);
        }
    }


    public function memberProfileUpdate(Request $request)
    {
        $applicant_info_data = collect($request->applicant_info)->toArray();
        $nominee_info_data = collect($request->nominee_info)->toArray();
        //backend validaiton
        // Retrieve the validated input...
        $approval_validated = $this->applicantInfoValiation($applicant_info_data)->validated();
        $nominee_validated = $this->nomineeInfoValidation($nominee_info_data)->validated();


        try {
            DB::beginTransaction();
            $member = Member::find($request->member_id)->load(['nominee', 'memberProfileUpdate', 'memberChoices']);

            //Changes check....................
            $changes_count = 0;
            $member_choice_count = 0;
            $memberArray = $member->toArray();

            //  dd($request->all(), $member->memberChoices);
            $member_choice_data = $request->member_choice;
            // dd($member_choice_data);
            foreach ($member_choice_data as $key => $member_choice_value) {
                $db_member_choice = $member->memberChoices->where('project_type', $member_choice_value['project_type'])->first();
                if (!is_null($db_member_choice) && isset($db_member_choice)) {
                    if ($db_member_choice->capacity_range == $member_choice_value['capacity_range']) $member_choice_count++;
                    if ($db_member_choice->flat_size == $member_choice_value['flat_size']) $member_choice_count++;
                    if ($db_member_choice->exp_bank_loan == $member_choice_value['exp_bank_loan']) $member_choice_count++;
                    if ($db_member_choice->num_flat_shares == $member_choice_value['num_flat_shares']) $member_choice_count++;
                    if ($db_member_choice->p_introducer_name == $member_choice_value['p_introducer_name']) $member_choice_count++;
                    if ($db_member_choice->p_introducer_member_num == $member_choice_value['p_introducer_member_num']) $member_choice_count++;
                    if (count($db_member_choice->prefered_area) != count($member_choice_value['prefered_area'])) $member_choice_count++;
                } else {
                    $member_choice_count++;
                }
            }
            // dd($member_choice_count);
            //member choices changes
            //  foreach($member->memberChoices as $key => $memberChoice){

            //     if($member_choice_data['pref_of_dcc'][$key]['name'] != $memberChoice->pref_of_dcc)   $member_choice_count++;
            //     if($member_choice_data['pref_close_dcc'][$key]['name'] != $memberChoice->pref_close_dcc)   $member_choice_count++;
            //     if($member_choice_data['flat_size'][$key]['name'] != $memberChoice->flat_size)   $member_choice_count++;
            //     if($member_choice_data['exp_bank_loan'][$key]['name'] != $memberChoice->exp_bank_loan)   $member_choice_count++;
            //     if($member_choice_data['num_flat_shares'][$key]['name'] != $memberChoice->num_flat_shares)   $member_choice_count++;
            //     if($member_choice_data['distict_pref'][$key]['name'] != $memberChoice->distict_pref)   $member_choice_count++;
            //     if($member_choice_data['capacity_range'][$key]['name'] != $memberChoice->capacity_range)   $member_choice_count++;

            //  }

            foreach ($memberArray as $key => $m_data) {
                if (!is_array($m_data)) {
                    if (isset($applicant_info_data[$key])) {
                        $changes =  $this->updateDataCheck($m_data, $applicant_info_data[$key]);
                        if (!is_null($changes)) {
                            $changes_count++;
                        }
                        // dd($changes);
                    }
                }
            }
            //applicant password has
            if (isset($applicant_info_data['password'])) {
                $changes_count++;
            }
            //nominee changes check
            foreach ($memberArray['nominee'] as $key => $m_data) {
                if (!is_array($m_data)) {
                    if (isset($nominee_info_data[$key])) {
                        $changes =  $this->updateDataCheck($m_data, $nominee_info_data[$key]);
                        if (!is_null($changes)) {
                            $changes_count++;
                        }
                        // dd($changes);
                    }
                }
            }

            // dd($changes_count,$memberArray);
            if ($changes_count <= 0 && $member_choice_count <= 0) {
                DB::commit();
                record_warning_flash('Nothing change for profile update!!');
                return response()->json([
                    'status' => 'success'
                ]);
            }
            //Changes check....................(end)

            if (isset($applicant_info_data['image']) && $applicant_info_data['image'] != null) {
                $old_image_path = isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->image) ? 'storage/' . Member::APPLICENT_IMAGE . '/' . $member->memberProfileUpdate->image : NULL;
                $applicant_info_data['image'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['image'], Member::APPLICENT_IMAGE, null, $old_image_path);
            }

            if (isset($applicant_info_data['nid_back']) && $applicant_info_data['nid_back'] != null) {
                $old_image_path =  isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->nid_back) ?  'storage/' . Member::APPLICENT_NID . '/' . $member->memberProfileUpdate->nid_back : NULL;
                $applicant_info_data['nid_back'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['nid_back'], Member::APPLICENT_NID, null, $old_image_path);
            }
            if (isset($applicant_info_data['nid_front']) && $applicant_info_data['nid_front'] != null) {
                $old_image_path = isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->nid_front) ?   'storage/' . Member::APPLICENT_NID . '/' . $member->memberProfileUpdate->nid_front : NULL;
                $applicant_info_data['nid_front'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['nid_front'], Member::APPLICENT_NID, null, $old_image_path);
            }
            if (isset($applicant_info_data['signature']) && $applicant_info_data['signature'] != null) {
                $old_image_path = isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->signature) ?  'storage/' . Member::APPLICENT_SIGNATURE . '/' . $member->memberProfileUpdate->signature : NULL;
                $applicant_info_data['signature'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['signature'], Member::APPLICENT_SIGNATURE, null, $old_image_path);
            }

            if (isset($applicant_info_data['proof_signed_by_sup_author']) && $applicant_info_data['proof_signed_by_sup_author'] != null) {
                $old_image_path = isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->proof_signed_by_sup_author) ?  'storage/' . Member::SUP_AUTH_PROOF . '/' . $member->memberProfileUpdate->proof_signed_by_sup_author : NULL;
                $applicant_info_data['proof_signed_by_sup_author'] =  $this->fileUploadService->uploadBase64File($applicant_info_data['proof_signed_by_sup_author'], Member::SUP_AUTH_PROOF, null, $old_image_path);
            }
            $applicant_info_data['formatted_number'] = $applicant_info_data['formattedNumber'];
            $applicant_info_data['country_code'] = $applicant_info_data['country_code'];

            // dd($request->all(), $changes_count);
            //nominee image update
            //nomine created
            if (isset($nominee_info_data['image']) && $nominee_info_data['image'] != null) {
                $old_image_path =  isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->nominee_image) ?  'storage/' . Member::NOMINEE_IMAGE . '/' . $member->memberProfileUpdate->nominee_image : NULL;
                $nominee_info_data['image'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['image'], Member::NOMINEE_IMAGE, null, $old_image_path);
            }
            if (isset($nominee_info_data['nid_back']) && $nominee_info_data['nid_back'] != null) {
                $old_image_path = isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->nominee_nid_back) ?  'storage/' . Member::NOMINEE_NID . '/' . $member->memberProfileUpdate->nominee_nid_back : NULL;
                $nominee_info_data['nid_back'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['nid_back'], Member::NOMINEE_NID, null, $old_image_path);
            }
            if (isset($nominee_info_data['nid_front']) && $nominee_info_data['nid_front'] != null) {
                $old_image_path = isset($member->memberProfileUpdate) && !is_null($member->memberProfileUpdate->nominee_nid_front) ?  'storage/' . Member::NOMINEE_NID . '/' . $member->memberProfileUpdate->nominee_nid_front : NULL;
                $nominee_info_data['nid_front'] =  $this->fileUploadService->uploadBase64File($nominee_info_data['nid_front'], Member::NOMINEE_NID, null, $old_image_path);
            }
            $nominee_info_data['formatted_number'] = $nominee_info_data['formattedNumber'] ?? '';
            $nominee_info_data['country_code'] = $nominee_info_data['country_code'] ?? '';

            if (!is_null($member->memberProfileUpdate)) {
                $member->memberProfileUpdate->delete();
            }
            // dd($member_choice_count);
            if ($member_choice_count > 0) {
                if ($member->memberChoicesUpdate->count() > 0) {
                    $member->memberChoicesUpdate()->delete();
                }
                //member choice creted
                foreach ($member_choice_data as $member_choice) {
                    $member_choice['member_id'] =  $member->id;
                    MemberChoiceUpdate::create($member_choice);
                }
                //member choice creted
                // for($i=0; $i<4; $i++){

                //     MemberChoiceUpdate::create([
                //         'member_id' => $member->id,
                //         'pref_of_dcc' => isset($member_choice_data['pref_of_dcc'][$i]) ? $member_choice_data['pref_of_dcc'][$i]['name'] : null,
                //         'pref_close_dcc' => isset($member_choice_data['pref_close_dcc'][$i]) ? $member_choice_data['pref_close_dcc'][$i]['name'] : null,
                //         'flat_size' => isset($member_choice_data['flat_size'][$i]) ? $member_choice_data['flat_size'][$i]['name'] : null,
                //         'exp_bank_loan' => isset($member_choice_data['exp_bank_loan'][$i]) ? $member_choice_data['exp_bank_loan'][$i]['name'] : null,
                //         'num_flat_shares' => isset($member_choice_data['num_flat_shares'][$i]) ? $member_choice_data['num_flat_shares'][$i]['name'] : null,
                //         'distict_pref' => isset($member_choice_data['distict_pref'][$i]) ? $member_choice_data['distict_pref'][$i]['name'] : null,
                //         'capacity_range' => isset($member_choice_data['capacity_range'][$i]) ? $member_choice_data['capacity_range'][$i]['name'] : null,

                //     ]);
                // }

            }



            $update_data = [
                'member_id' => $member->id,
                'name' => $this->updateDataCheck($member->name, $applicant_info_data['name']),
                'father_name' => $this->updateDataCheck($member->father_name, $applicant_info_data['father_name'] ?? NULL),
                'mother_name' => $this->updateDataCheck($member->mother_name, $applicant_info_data['mother_name'] ?? NULL),
                'image' => $this->updateDataCheck($member->image, $applicant_info_data['image'] ?? NULL),
                'spouse_name' => $this->updateDataCheck($member->spouse_name, $applicant_info_data['spouse_name'] ?? NULL),
                'bcs_batch' => $this->updateDataCheck($member->bcs_batch, $applicant_info_data['bcs_batch'] ?? NULL),
                'joining_date' => $this->updateDataCheck($member->joining_date, $applicant_info_data['joining_date'] ?? NULL),

                'cader_id' => $this->updateDataCheck($member->cader_id, $applicant_info_data['cader_id'] ?? NULL),

                'birth_date' => $this->updateDataCheck($member->birth_date, $applicant_info_data['birth_date'] ?? NULL),

                'gender' => $this->updateDataCheck($member->gender, $applicant_info_data['gender'] ?? NULL),

                //mobile. formmatted and country code store
                'mobile' => $this->updateDataCheck($member->mobile, $applicant_info_data['mobile'] ?? NULL),
                'formatted_number' => $this->updateDataCheck($member->formatted_number, $applicant_info_data['formattedNumber'] ?? NULL),
                'country_code' => $this->updateDataCheck($member->country_code, $applicant_info_data['country_code'] ?? NULL),


                //mobile. formmatted and country code store
                'nominee_mobile' => $this->updateDataCheck($member->nominee->mobile, $nominee_info_data['mobile'] ?? NULL),
                'nominee_formatted_number' => $this->updateDataCheck($member->nominee->formatted_number, $nominee_info_data['formattedNumber'] ?? NULL),
                'nominee_country_code' =>  $this->updateDataCheck($member->nominee->country_code, $nominee_info_data['country_code'] ?? NULL),


                'email' => $this->updateDataCheck($member->email, $applicant_info_data['email'] ?? NULL),

                'password' => isset($applicant_info_data['password']) ? $this->updateDataCheck($member->password, Hash::make($applicant_info_data['password']) ?? NULL) : null,

                'office_address' => $this->updateDataCheck($member->office_address, $applicant_info_data['office_address'] ?? NULL),

                'nid' => $this->updateDataCheck($member->nid, $applicant_info_data['nid'] ?? NULL),
                'nid_front' => $this->updateDataCheck($member->nid_front, $applicant_info_data['nid_front'] ?? NULL),

                'nid_back' => $this->updateDataCheck($member->nid_back, $applicant_info_data['nid_back'] ?? NULL),

                'signature' => $this->updateDataCheck($member->signature, $applicant_info_data['signature'] ?? NULL),

                'ref_name' => $this->updateDataCheck($member->ref_name, $applicant_info_data['ref_name'] ?? NULL),
                'ref_mobile' => $this->updateDataCheck($member->ref_mobile, $applicant_info_data['ref_mobile'] ?? NULL),
                'ref_memeber_id_no' => $this->updateDataCheck($member->ref_memeber_id_no, $applicant_info_data['ref_memeber_id_no'] ?? NULL),

                'proof_signed_by_sup_author' => $this->updateDataCheck($member->proof_signed_by_sup_author, $applicant_info_data['proof_signed_by_sup_author'] ?? NULL),
                'present_address' => $this->updateDataCheck($member->present_address, $applicant_info_data['present_address'] ?? NULL),
                'permanent_address' => $this->updateDataCheck($member->permanent_address, $applicant_info_data['permanent_address'] ?? NULL),
                'emergency_contact' => $this->updateDataCheck($member->emergency_contact, $applicant_info_data['emergency_contact'] ?? NULL),

                'nominee_name' => $this->updateDataCheck($member->nominee->name, $nominee_info_data['name'] ?? NULL),
                'nominee_father_name' => $this->updateDataCheck($member->nominee->father_name, $nominee_info_data['father_name'] ?? NULL),
                'nominee_mother_name' => $this->updateDataCheck($member->nominee->mother_name, $nominee_info_data['mother_name'] ?? NULL),
                'nominee_image' => $this->updateDataCheck($member->nominee->image, $nominee_info_data['image'] ?? NULL),
                'nominee_birth_date' => $this->updateDataCheck($member->nominee->birth_date, $nominee_info_data['birth_date'] ?? NULL),

                'nominee_gender' => $this->updateDataCheck($member->nominee->gender, $nominee_info_data['gender'] ?? NULL),
                'nominee_mobile' => $this->updateDataCheck($member->nominee->mobile, $nominee_info_data['mobile'] ?? NULL),
                'nominee_relation_with_user' => $this->updateDataCheck($member->nominee->relation_with_user, $nominee_info_data['relation_with_user'] ?? NULL),
                'nominee_nid' => $this->updateDataCheck($member->nominee->nid, $nominee_info_data['nid'] ?? NULL),
                'nominee_nid_front' => $this->updateDataCheck($member->nominee->nid_front, $nominee_info_data['nid_front'] ?? NULL),
                'nominee_nid_back' => $this->updateDataCheck($member->nominee->nid_back, $nominee_info_data['nid_back'] ?? NULL),
                'nominee_professional_details' => $this->updateDataCheck($member->nominee->professional_details, $nominee_info_data['professional_details'] ?? NULL),
                'nominee_permanent_address' => $this->updateDataCheck($member->nominee->permanent_address, $nominee_info_data['permanent_address'] ?? NULL),

                'status' => MemberProfileUpdate::STATUS_PENDING,
                'alert_notify' => null,
                'created_by' => Auth::guard('web')->user()->id,
                'updated_by' => null,
            ];

            // dd($update_data);

            MemberProfileUpdate::create($update_data);
            DB::commit();
            record_warning_flash('Your profile is pending for approval');
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            something_wrong_flash($e->getMessage());
        }
    }

    public function updateDataCheck($oldData, $newData)
    {
        if (!is_null($oldData) && !is_null($newData)) {
            if ($oldData != $newData) {
                return $newData;
            }
        }

        return NULL;
    }
}
