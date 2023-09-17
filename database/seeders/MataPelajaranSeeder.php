<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapel = [
            [
                'name' => 'Matematika'
            ],
            [
                'name' => 'Bahasa Indonesia'
            ],
            [
                'name' => 'Fisika'
            ]
        ];

        foreach($mapel as $value){
            MataPelajaran::create($value);
        }
    }
}
