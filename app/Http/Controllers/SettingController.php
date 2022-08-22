<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Kelas;
use App\models\JenisKelamin;
use App\models\Jabatan;
use App\models\MataPelajaran;

class SettingController extends Controller
{
    public function kelas(){
        $kelas = Kelas::orderBy('id', 'asc')->get();
        return ['status' => "success", "data" => $kelas, 'message' => 'Data berhasil didapat'];
    }

    public function addKelas(Request $request){
        $validateKelas = Kelas::where('name', $request->nama)->get();
        if(count($validateKelas) > 0){
            return ['status' => "fail", 'message' => 'Kelas sudah ada'];
        }else{
            $kelas = Kelas::create([
                'name' => $request->nama
            ]);

            if($kelas){
                return ['status' => "success", 'message' => 'Berhasil menambahkan data'];
            }else{
                return ['status' => "fail", 'message' => 'Gagal menambahkan data'];
            }
        }
    }

    public function editKelas(Request $request, $id){
        $kelas = Kelas::where('id', $id)->first();
        $validateKelas = Kelas::whereNotIn('name', [$kelas->name])->get();
        foreach($validateKelas as $value){
            if($value->name === $request->nama){
                return ['status' => "fail", 'message' => 'Kelas sudah ada'];
            }
        }

        $kelas->name = $request->nama;
        $kelas->save();

        if($kelas){
            return ['status' => "success", 'message' => 'Berhasil mengubah data'];
        }else{
            return ['status' => "fail", 'message' => 'Gagal mengubah data'];
        }
    }

    public function jenisKelamin(){
        $jk = Jeniskelamin::all();
        return ['status' => "success", "data" => $jk, 'message' => 'Data berhasil didapat'];
    }

    public function jabatan(){
        $jabatan = Jabatan::all();
        return ['status' => "success", "data" => $jabatan, 'message' => 'Data berhasil didapat'];
    }

    public function addJabatan(Request $request){
        $validateJabatan = Jabatan::where('name', $request->nama)->get();
        if(count($validateJabatan) > 0){
            return ['status' => "fail", 'message' => 'Jabatan sudah ada'];
        }else{
            $jabatan = Jabatan::create([
                'name' => $request->nama
            ]);

            if($jabatan){
                return ['status' => "success", 'message' => 'Berhasil menambahkan data'];
            }else{
                return ['status' => "fail", 'message' => 'Gagal menambahkan data'];
            }
        }
    }

    public function allMataPelajaran(){
        $mapel = MataPelajaran::orderBy('id', 'asc')->get();
        return ['status' => "success", "data" => $mapel, 'message' => 'Data berhasil didapat'];
    }

    public function addMataPelajaran(Request $request){
        $validateMapel = MataPelajaran::where('name', $request->nama)->get();
        if(count($validateMapel) > 0){
            return ['status' => "fail", 'message' => 'Mata Pelajaran sudah ada'];
        }else{
            $mapel = MataPelajaran::create([
                'name' => $request->nama
            ]);

            if($mapel){
                return ['status' => "success", 'message' => 'Berhasil menambahkan data'];
            }else{
                return ['status' => "fail", 'message' => 'Gagal menambahkan data'];
            }
        }
    }

    public function editMataPelajaran(Request $request, $id){
        $mapel = MataPelajaran::where('id', $id)->first();
        $validateMapel = MataPelajaran::whereNotIn('name', [$mapel->name])->get();
        foreach($validateMapel as $value){
            if($value->name === $request->nama){
                return ['status' => "fail", 'message' => 'Mata Pelajaran sudah ada'];
            }
        }

        $mapel->name = $request->nama;
        $mapel->save();

        if($mapel){
            return ['status' => "success", 'message' => 'Berhasil mengubah data'];
        }else{
            return ['status' => "fail", 'message' => 'Gagal mengubah data'];
        }
    }

}
