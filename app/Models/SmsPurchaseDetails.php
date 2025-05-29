<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsPurchaseDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_order_id',
        'amount',
        'invoice_no',
        'sp_message',
        'method',
        'date_time',
    ];
}
