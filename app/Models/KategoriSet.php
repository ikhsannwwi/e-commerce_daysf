<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSet extends Model
{
    use HasFactory;

    protected $table = 'kategori_set';

    protected $guarded = ['id'];
}
