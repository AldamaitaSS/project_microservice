<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuModel extends Model
{
    use HasFactory;
    protected $table = 'm_buku';
    protected $primaryKey = 'buku_id';
    protected $fillable = ['judul', 'penulis', 'stok', 'kategori_id'];

    public $timestamps = false;

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}
