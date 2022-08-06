<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $kelas = [
            [
                'name' => 'Kelas 1'
            ],
            [
                'name' => 'Kelas 2'
            ],
            [
                'name' => 'Kelas 3'
            ]
        ];

        foreach($kelas as $value){
            Kelas::create($value);
        }
    }
}
