<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamModel extends Model
{
    use HasFactory;
    protected $table = "m_pinjam";
    protected $primaryKey = "pinjam_id";
    protected $fillable = [ 'user_id', 'buku_id', 'tanggal_pinjam', 'tangga_kembali', 'status'];

    public $timestamps = false;

    
}
