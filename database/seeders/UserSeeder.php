<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama_lengkap' => 'Super Admin',
            'username' => '122333',
            'password' => bcrypt('123456'),
            'tanggal_lahir' => '1990-07-12',
            'foto' => '/assets/images/example.png',
            'no_hp' => '1351673251763',
            'id_jenis_kelamin' => 1,
            'id_jabatan' => 1,
            'id_kelas' => 1
        ]);
    }
}
