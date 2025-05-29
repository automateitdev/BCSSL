<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberChoiceUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'project_type',
        'prefered_area',
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

    public $casts = [
        'prefered_area' => 'array'
    ];

}
