<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsRecharge extends Model
{
    use HasFactory;
    protected $fillable = [
        'sms_quantity'
    ];
}
