<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_kategori';
    protected $primaryKey = 'kategori_id';

    public function archive()
    {
        return $this->hasMany(Archive::class, 'id_kategori', 'kategori_id');
    }
}
