<?php

namespace App\Models;

use App\Models\FeeAssign;
use App\Models\AssociatorsInfo;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\Scopes\ScopeActive;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, ScopeActive;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'gender',
        'user_type',
        'mobile',
        'email',
        'password',
        'nid',
        'status',
        'created_by',
        'updated_by',
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


    public const USER_BLOOD_GROUP = [
        'o_positive' => 'O (+ve)',
        'o_negative' => 'O (-ve)',
        'a_positive' => 'A (+ve)',
        'a_negative' => 'A (-ve)',
        'b_positive' => 'B (+ve)',
        'b_negative' => 'B (-ve)',
        'ab_positive' => 'AB (+ve)',
        'ab_negative' => 'AB (-ve)',
    ];



    public const USER_STATUS = [
        self::USER_ACTIVE => self::USER_ACTIVE,
        self::USER_INACTIVE => self::USER_INACTIVE,
    ];

    public const USER_ACTIVE = 'active';
    public const USER_INACTIVE = 'inactive';

    public static $seederMail = ['admin@app.com','demo@app.com'];

    protected $appends = ['avatar_url'];

    public const ADMIN_IMAGE = 'admin';

    public const APPLICENT_IMAGE = 'member/user';
    // public const APPLICENT_NID = 'member/nid';
    // public const APPLICENT_SIGNATURE = 'member/signature';
    // public const NOMINEE_IMAGE = 'nominee/user';
    // public const NOMINEE_NID = 'nominee/nid';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_SUSPENDED= 'suspended';

    public const USER_TYPE_MEMEBER = 'member';
    public const USER_TYPE_SUPERADMIN = 'superadmin';

    public function associatorsInfo()
    {
        return $this->hasOne(AssociatorsInfo::class,'user_id','id');
    }

    public function feeAssigns()
    {
        return $this->hasMany(FeeAssign::class,'user_id','id');
    }

    public function getAvatarUrlAttribute()
    {
        return get_storage_image(self::APPLICENT_IMAGE, $this->image, 'user');
    }


    public function paymentCreate()
    {
        return $this->morphOne(PaymentCreate::class, 'paymentable');
    }

}
