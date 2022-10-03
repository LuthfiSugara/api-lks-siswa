<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\JenisUjian;

class JenisUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ujian = ["Ulangan", "Latihan", "Tugas", "Kuis"];

        foreach($ujian as $value){
            JenisUjian::create([
                'name' => $value
            ]);
        }
    }
}
