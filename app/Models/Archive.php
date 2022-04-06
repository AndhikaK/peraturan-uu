<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $table = 'tbl_arsip';
    protected $primaryKey = 'id_arsip';

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }
}
