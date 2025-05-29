<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'sms_length',
        'number',
        'msg',
        'response',
        'status'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
