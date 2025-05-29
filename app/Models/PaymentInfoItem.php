<?php

namespace App\Models;

use App\Models\FeeSetup;
use App\Models\FeeAssign;
use App\Models\PaymentInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentInfoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_info_id',
        'fee_assign_id',
        'assign_date',
        'amount',
        'fine_amount',
        'monthly',
    ];

    public function paymentInfo(){
        return $this->belongsTo(PaymentInfo::class, 'payment_info_id', 'id');
    }
    public function feeAssign(){
        return $this->belongsTo(FeeAssign::class, 'fee_assign_id', 'id');
    }

    public function feeSetup(){
        return $this->hasOneThrough(
            FeeSetup::class,
            FeeAssign::class,
            'id',
            'id',
            'fee_assign_id',
            'fee_setup_id',


        );
    }
}
