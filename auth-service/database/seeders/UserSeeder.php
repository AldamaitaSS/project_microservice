<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'user_id' => 8,
                'level_id' => 2,
                'nama' => 'Aldamaita',
                'username' => 'alda1',
                'password' => Hash::make('123456')
            ],
            [
                'user_id' => 9,
                'level_id' => 1,
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin123')
            ],

        ];
        DB::table('m_user')->insert($data);
    }
}
