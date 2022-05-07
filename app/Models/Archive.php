<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $table = 'uu';
    protected $primaryKey = 'id_tbl_uu';

    protected $guarded = ['id_tbl_uu'];
    const UPDATED_AT = null;
    const CREATED_AT = null;


    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    public function pasal()
    {
        return $this->hasMany(Pasal::class, 'id_tbl_uu', 'id_tbl_uu');
    }
}
