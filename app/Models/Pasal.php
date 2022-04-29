<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasal extends Model
{
    use HasFactory;

    protected $table = 'uu_pasal_html';
    protected $primaryKey = 'id';

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }
}
