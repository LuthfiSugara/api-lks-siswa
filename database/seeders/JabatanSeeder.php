<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = [
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'Guru'
            ],
            [
                'name' => 'Siswa'
            ]
        ];

        foreach($jabatan as $value){
            Jabatan::create($value);
        }

    }
}
