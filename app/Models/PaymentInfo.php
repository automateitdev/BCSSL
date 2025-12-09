<?php

namespace App\Models;

use App\Models\Ledger;
use App\Models\Member;
use App\Models\FeeAssign;
use App\Models\PaymentCreate;
use App\Models\PaymentInfoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'member_id',
        'ladger_id',
        'document_files',
        'fine_amount',
        'payable_amount',
        'total_amount',
        'reasons',
        'status',
        'payment_date',
        'created_by',
        'payment_status',
        'status_code',
        'transaction_id',
        'transaction_date',
        'br_code',
        'pay_mode',
        'vat',
        'commission',
        'scroll_no',
        'payment_type',
        'session_token',
        'spg_pay_amount'
    ];

    public const DOCUMENT_FILES = 'public/payment/documents';
    public const DOCUMENT_FILES_VIEW = 'payment/documents';

    public const STATUS_COMPLETE= 'completed';
    public const STATUS_PENDING= 'pending';
    public const STATUS_SUSPEND = 'suspend';
    public const STATUS_FAILED = 'failed';

    //payment type
    public const PAYMENT_TYPE_MANUAL ='manual';
    public const PAYMENT_TYPE_ONLINE ='online';

    public const ALL_PAYMENT_TYPE = [
        self::PAYMENT_TYPE_MANUAL => self::PAYMENT_TYPE_MANUAL,
        self::PAYMENT_TYPE_ONLINE => self::PAYMENT_TYPE_ONLINE,
    ];

    public const ALL_PAYMENT_STATUS = [
        self::STATUS_COMPLETE => self::STATUS_COMPLETE,
        self::STATUS_PENDING => self::STATUS_PENDING,
        self::STATUS_SUSPEND => self::STATUS_SUSPEND,
    ];


    public function associatorsInfo()
    {
        return $this->belongsTo(AssociatorsInfo::class,'member_id', 'id');
    }

    public function paymentsInfoItems()
    {
        return $this->hasMany(PaymentInfoItem::class, 'payment_info_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public function ledger(){
        return $this->belongsTo(Ledger::class, 'ladger_id', 'id');
    }

    public function feeAssign(){
        return $this->hasManyThrough(
            FeeAssign::class,
            PaymentInfoItem::class,
            'payment_info_id',
            'id',
            'id',
            'fee_assign_id',
        );
    }
}
