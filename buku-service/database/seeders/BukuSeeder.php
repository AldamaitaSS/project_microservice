<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'buku_id'=> 1,
                'judul'=>'dasar pemograman',
                'penulis'=>'ishac',
                'stok'=> 1,
            ],
        ];

        DB::table('m_buku')->insert($data);
    }
}
