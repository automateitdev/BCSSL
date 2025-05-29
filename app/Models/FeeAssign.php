<?php

namespace App\Models;

use App\Models\Member;
use App\Models\PaymentInfoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeAssign extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'fee_setup_id',
        'assign_date',
        'fine_date',
        'monthly',
        'amount',
        'fine_amount',
        'status',
        'fine_status',
    ];

    public const STATUS_DUE = 'Unpaid';
    public const STATUS_PAID = 'Paid';
    public const STATUS_REQUEST = 'Requested';
    public const STATUS_FINE = 'fine';

    public function user(){
        return $this->belongsTo(Member::class,'member_id','id');
    }
    public function fee_setup(){
        return $this->belongsTo(FeeSetup::class,'fee_setup_id','id');
    }

    public function paymentInfoItem(){
        return $this->hasOne(PaymentInfoItem::class, 'fee_assign_id','id');
    }

    public function fineDates(){
        return $this->hasMany(FineDate::class, 'fee_assign_id','id');
    }
}
