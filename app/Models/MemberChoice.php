<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'prefered_area',
        'project_type',
        'pref_of_dcc',
        'pref_close_dcc',
        'flat_size',
        'exp_bank_loan',
        'num_flat_shares',
        'distict_pref',
        'capacity_range',
        'p_introducer_name',
        'p_introducer_member_num',
    ];

    protected $casts = [
        'prefered_area' => 'array'
    ];
}
