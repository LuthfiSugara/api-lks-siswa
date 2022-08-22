<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\JenisKelamin;

class JenisKelaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_kelamin = [
            [
                'name' => 'Laki-laki'
            ],
            [
                'name' => 'Perempuan'
            ]
        ];

        foreach($jenis_kelamin as $value){
            JenisKelamin::create($value);
        }
    }
}
