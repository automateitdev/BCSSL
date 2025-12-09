<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $fillable = [
        'invoice',
        'session_token',
        'fee_assign_ids',
        'total_amount',
        'status',
        'spg_transaction_id',
        'gateway_status_code',
        'creator_id',
        'created_by',
        'paid_at',
    ];

    protected $casts = [
        'fee_assign_ids' => 'array',
        'paid_at'        => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
