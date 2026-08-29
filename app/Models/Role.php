<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name', 'slug', 'description', 'permissions', 'status'];

    protected static function booted()
    {
        static::addGlobalScope('superAdmin', function (Builder $builder) {
            $builder->where('name', '!=', 'Super Admin');
        });
    }
}
