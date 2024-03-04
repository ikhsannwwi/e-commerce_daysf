<?php

namespace App\Models;

use App\Models\SetImage;
use App\Models\SetDetail;
use App\Models\KategoriSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Set extends Model
{
    use HasFactory;

    protected $table = 'set';

    protected $guarded = ['id'];

    public function detail(){
        return $this->hasMany(SetDetail::class, 'set_id', 'id');
    }

    public function image(){
        return $this->hasMany(SetImage::class, 'set_id', 'id');
    }

    public function kategori(){
        return $this->belongsTo(KategoriSet::class, 'kategori_id', 'id');
    }
}
