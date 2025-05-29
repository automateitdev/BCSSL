<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerTrace extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'voucher_id',
        'invoice_no',
        'ledger_id',
        'debit',
        'credit',
        'reference',
        'description',
        'voucher_date'
    ];

    public function Ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

    public function feehead()
    {
        return $this->belongsTo(FeeSetup::class);
    }
}
