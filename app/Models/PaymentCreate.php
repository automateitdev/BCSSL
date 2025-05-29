<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCreate extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_info_id',
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }
}
