<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeSetup extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_head',
        'ledger_id',
        'date',
        'monthly',
        'fine',
        'amount'
    ];

    public function ledger(){
        return $this->belongsTo(Ledger::class,'ledger_id','id');
    }
}
