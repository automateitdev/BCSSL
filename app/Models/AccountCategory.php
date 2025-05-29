<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function account_groups()
    {
        return $this->hasMany(AccountGroup::class);
    }
}
