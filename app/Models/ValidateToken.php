<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ValidateToken extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'phone',
        'code',
        'expires_date',
        'attempts_number',
        'code_attempts_number',
        'request_code_number',
        'is_code_validated'
    ];

    protected $casts = [
        'expires_date' => 'date',
    ];
}
