<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'name',
        'father_name',
        'mother_name',
        'image',
        'birth_date',
        'gender',
        'mobile',
        'formatted_number',
        'country_code',
        'relation_with_user',
        'nid',
        'nid_front',
        'nid_back',
        'professional_details',
        'permanent_address',

    ];

    public const NOMINEE_IMAGE = 'nominee/user';
    public const NOMINEE_NID = 'nominee/nid';

    protected $appends = ['avatar_url','nid_front_image','nid_back_image'];

    public function getAvatarUrlAttribute()
    {
        return get_storage_image(self::NOMINEE_IMAGE, $this->image, 'user');
    }
    public function getNidFrontImageAttribute(){
        return get_storage_image(self::NOMINEE_NID, $this->nid_front);
    }
    public function getNidBackImageAttribute(){
        return get_storage_image(self::NOMINEE_NID, $this->nid_back);
    }

}
