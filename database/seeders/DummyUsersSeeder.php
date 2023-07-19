<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Pimpinan',
                'email' => 'pimpinan@gmail.com',
                'role' => 'pimpinan',
                'password' => bcrypt('pimpinan')
            ],
            [
                'name' => 'Pegawai1',
                'email' => 'pegawai1@gmail.com',
                'role' => 'pegawai',
                'password' => bcrypt('pegawai1')
            ],
            [
                'name' => 'Pegawai2',
                'email' => 'pegawai2@gmail.com',
                'role' => 'pegawai',
                'password' => bcrypt('pegawai2')
            ]
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}