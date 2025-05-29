<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'acc_group_id',
        'ledger_name'
    ];

    public function account_group()
    {
        return $this->belongsTo(AccountGroup::class, 'acc_group_id');
    }

    public function ledger_traces()
    {
        return $this->hasMany(LedgerTrace::class);
    }

    public const AG_INCOME_FOR_FEE_ID = 23;
}
