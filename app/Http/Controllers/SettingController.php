<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Kelas;
use App\models\JenisKelamin;
use App\models\Jabatan;

class SettingController extends Controller
{
    public function kelas(){
        $kelas = Kelas::all();
        return ['status' => "success", "data" => $kelas, 'message' => 'Data berhasil didapat'];
    }

    public function jenisKelamin(){
        $jk = Jeniskelamin::all();
        return ['status' => "success", "data" => $jk, 'message' => 'Data berhasil didapat'];
    }

    public function jabatan(){
        $jabatan = Jabatan::all();
        return ['status' => "success", "data" => $jabatan, 'message' => 'Data berhasil didapat'];
    }

}
