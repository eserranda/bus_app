<?php

namespace Database\Seeders;

use App\Models\BusSeat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusSeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 22; $i++) {
            BusSeat::create([
                'id_bus' => 3, // ubah sesuai id bus yang akan dipakai
                'nomor_kursi' => $i,
            ]);
        }
    }
}
