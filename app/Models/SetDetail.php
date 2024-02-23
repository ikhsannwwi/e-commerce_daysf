<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetDetail extends Model
{
    use HasFactory;

    protected $table = 'set_detail';

    protected $guarded = ['id'];
}
