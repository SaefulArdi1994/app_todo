<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    protected $table = 'password_reset_tokens';
    protected $fillable = ['email', 'token'];
    //const updated_at = null;
    public $timestamps = false;
}
