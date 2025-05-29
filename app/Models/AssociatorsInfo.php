<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssociatorsInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'membershp_number',
        'approval_date',
        'num_or_shares',
    ];

    public function user(){
        return $this->belongsTo(Member::class,'member_id','id');
    }
}
