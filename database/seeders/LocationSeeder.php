<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = [
            [
                'name' => 'Rumah'
            ],
            [
                'name' => 'Sekolah'
            ]
        ];

        foreach($location as $value){
            Location::create($value);
        }
    }
}
