<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'guard_name', 'parent_id'];

    protected $table = 'permissions';

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }
}
