<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    public $table = 'password_resets';
    
    protected $fillable = ['email', 'token'];
    public $timestamps = false;
    public $incrementing = false;
}
