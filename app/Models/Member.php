<?php

namespace App\Models;

use App\Models\Nominee;
use App\Models\FeeAssign;
use App\Models\AssociatorsInfo;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'father_name',
        'mother_name',
        'image',
        'spouse_name',
        'bcs_batch',
        'joining_date',
        'cader_id',
        'birth_date',
        'gender',
        'user_type',
        'mobile',
        'formatted_number',
        'country_code',
        'email',
        'password',
        'office_address',
        'nid',
        'nid_front',
        'nid_back',
        'signature',
        'present_address',
        'permanent_address',
        'emergency_contact',
        'joining_cader_proof',
        'supervising_authority_proof',
        'created_by',
        'updated_by',
        'proof_joining_cadre',
        'proof_signed_by_sup_author',
        'ref_name',
        'ref_mobile',
        'ref_memeber_id_no',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const USER_GENDER = [
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other'
    ];

    protected $appends = ['avatar_url','signature_image','nid_front_image','nid_back_image'];

    public const APPLICENT_IMAGE = 'member/user';
    public const APPLICENT_NID = 'member/nid';
    public const APPLICENT_SIGNATURE = 'member/signature';
    public const NOMINEE_IMAGE = 'nominee/user';
    public const NOMINEE_NID = 'nominee/nid';
    public const JOIN_PROOF = 'nominee/joinproof';
    public const SUP_AUTH_PROOF = 'nominee/supauthproof';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_SUSPENDED= 'suspended';

    public const USER_TYPE_MEMEBER = 'member';
    public const USER_TYPE_SUPERADMIN = 'superadmin';

    public function associatorsInfo()
    {
        return $this->hasOne(AssociatorsInfo::class);
    }

    public function feeAssigns()
    {
        return $this->hasMany(FeeAssign::class,'member_id','id');
    }

    public function getAvatarUrlAttribute()
    {
        return get_storage_image(self::APPLICENT_IMAGE, $this->image, 'user');
    }
    public function getSignatureImageAttribute(){
        return get_storage_image(self::APPLICENT_SIGNATURE, $this->signature);
    }

    // 'nid_front',
    // 'nid_back',
    // 'nid_front_image','nid_back_image'
    public function getNidFrontImageAttribute(){
        return get_storage_image(self::APPLICENT_NID, $this->nid_front);
    }
    public function getNidBackImageAttribute(){
        return get_storage_image(self::APPLICENT_NID, $this->nid_back);
    }


    public function paymentCreate()
    {
        return $this->morphOne(PaymentCreate::class, 'paymentable');
    }

    public function nominee(){
        return $this->hasOne(Nominee::class,'member_id','id');
    }

    public function memberProfileUpdate(){
        return $this->hasOne(MemberProfileUpdate::class,'member_id','id');
    }

    public function memberChoices(){
        return $this->hasMany(MemberChoice::class,'member_id','id');
    }
    public function memberChoicesUpdate(){
        return $this->hasMany(MemberChoiceUpdate::class,'member_id','id');
    }

    public function paymentInfos(){
        return $this->hasMany(PaymentInfo::class,'member_id','id');
    }

}
