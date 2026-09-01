<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'email',
        'phone',
        'body',
        'is_seen',
    ];

    protected function casts(): array
    {
        return [
            'is_seen' => 'boolean',
        ];
    }
}
