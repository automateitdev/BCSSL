<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    public function ledger_from()
    {
        return $this->belongsTo(Ledger::class, 'ledger_from_id'); //Relation with Ledger model (one
    }

    public function ledger_to()
    {
        return $this->belongsTo(Ledger::class, 'ledger_to_id'); //Relation with Ledger model (one
    }
}
