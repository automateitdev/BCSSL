<?php

namespace App\Models;

use App\Models\Ledger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'acc_category_id',
        'group_name',
        'nature',
        'note'
    ];

     public function ledgers()
    {
        return $this->hasMany(Ledger::class,'acc_group_id','id');
    }

    public function account_category()
    {
        return $this->belongsTo(AccountCategory::class, 'acc_category_id');
    }
}
