<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $table = 'uu';
    protected $primaryKey = 'id_tbl_uu';

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }
}
