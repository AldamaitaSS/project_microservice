<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['nama', 'username', 'password', 'level_id'];

    public $timestamps = false; 

    protected $hidden   = ['password']; // jangan di tampilkan saat select

    protected $casts    = ['password' => 'hashed']; // casting password agar otomatis di hash

    public function getJWTIdentifier()
    {
        // Mengembalikan identifier unik pengguna (biasanya ID pengguna)
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Mengembalikan klaim tambahan untuk token JWT (bisa dikosongkan jika tidak diperlukan)
        return [];
    }

    public function getRoleName(): string{
        return $this->level->level_nama;
    }

    // apakah user memiliki role tertentu
    public function hasRole($role): bool{
        return $this->level->level_kode == $role;
    }

    // Mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
}
