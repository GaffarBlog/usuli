<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public function scopeKey($query, string $key)
    {
        return $query->where('key', $key);
    }
}
