<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $primaryKey = 'email';

    public $timestamps = false;



    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
        'code',
        'expire_at',
        'update_at',
    ];
}
