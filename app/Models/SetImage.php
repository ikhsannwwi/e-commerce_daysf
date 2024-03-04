<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetImage extends Model
{
    use HasFactory;
    
    protected $table = 'set_image';

    protected $guarded = ['id'];
}
