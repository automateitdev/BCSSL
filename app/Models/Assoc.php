<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_no',
        'join_date',
        'share_no',
        'share_quantity',
        'bcs_batch',
        'company',
        'designation'
    ];
}
