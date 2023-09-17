<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSoal;

class JenisSoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $soal = ["Pilihan Ganda", "Essay"];

        foreach($soal as $value){
            JenisSoal::create([
                'name' => $value
            ]);
        }
    }
}
