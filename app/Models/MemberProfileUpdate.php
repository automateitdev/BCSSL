<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Nominee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberProfileUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
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
        'mobile',
        'formatted_number',
        'country_code',
        'nominee_formatted_number',
        'nominee_country_code',
        'email',
        'password',
        'office_address',
        'nid',
        'nid_front',
        'nid_back',
        'signature',
        'proof_joining_cadre',
        'proof_signed_by_sup_author',
        'present_address',
        'permanent_address',
        'emergency_contact',
        'nominee_name',
        'nominee_father_name',
        'nominee_mother_name',
        'nominee_image',
        'nominee_birth_date',
        'nominee_gender',
        'nominee_mobile',
        'nominee_relation_with_user',
        'nominee_nid',
        'nominee_nid_front',
        'nominee_nid_back',
        'nominee_professional_details',
        'nominee_permanent_address',
        'status',
        'ref_name',
        'ref_mobile',
        'ref_memeber_id_no',
        'alert_notify',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['avatar_url','signature_image','nid_front_image','nid_back_image','nominee_avater_url','nominee_nid_front_image','nominee_nid_back_image'];

    public const STATUS_APPROVE = 'approve';
    public const STATUS_INAPPROVE = 'unapproved';
    public const STATUS_PENDING = 'pending';

    PUBLIC CONST ALL_STATUS = [
        self::STATUS_APPROVE => self::STATUS_APPROVE,
        self::STATUS_INAPPROVE => self::STATUS_INAPPROVE,
        self::STATUS_PENDING => self::STATUS_PENDING,
    ];

    public function member(){
        return $this->belongsTo(Member::class,'member_id','id');
    }


    public function feeAssigns()
    {
        return $this->hasMany(FeeAssign::class,'member_id','id');
    }

    public function getAvatarUrlAttribute()
    {
        if(!is_null($this->image)){

            return get_storage_image(Member::APPLICENT_IMAGE, $this->image, 'user');
        }
    }
    public function getSignatureImageAttribute(){
        if(!is_null($this->signature)){

            return get_storage_image(Member::APPLICENT_SIGNATURE, $this->signature);
        }
    }

    // 'nid_front',
    // 'nid_back',
    // 'nid_front_image','nid_back_image'
    public function getNidFrontImageAttribute(){
        if(!is_null($this->nid_front)){

            return get_storage_image(Member::APPLICENT_NID, $this->nid_front);
        }
    }
    public function getNidBackImageAttribute(){
        if(!is_null($this->nid_back)){

            return get_storage_image(Member::APPLICENT_NID, $this->nid_back);
        }
    }

    // nominee_avater_url
    public function getNomineeAvaterUrlAttribute()
    {
        if(!is_null($this->nominee_image)){
            return get_storage_image(Nominee::NOMINEE_IMAGE, $this->nominee_image);
        }

    }
    public function getNomineeNidFrontImageAttribute(){
        if(!is_null($this->nominee_nid_front)){

            return get_storage_image(Nominee::NOMINEE_NID, $this->nominee_nid_front);
        }
    }
    public function getNomineeNidBackImageAttribute(){
        if(!is_null($this->nominee_nid_back)){

            return get_storage_image(Nominee::NOMINEE_NID, $this->nominee_nid_back);
        }
    }

}
