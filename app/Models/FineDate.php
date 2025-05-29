<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FineDate extends Model
{
    use HasFactory;

    protected $fillable = [
      'fee_assign_id',
      'find_date',
      'status',
    ];

    public const STATUS_COMPLETE = 'complete';
    public const STATUS_INCOMPLETE = 'incomplete';
}
