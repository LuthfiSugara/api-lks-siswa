<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Kelas;
use App\models\DetailKelasUser;

class ClassController extends Controller
{
    public function getCLassByTeacherId(Request $request, $id){
        $kelas = DetailKelasUser::with([
            'detail' => function($q){
                $q->select('id', 'name');
            }
        ])
        ->where('id_user', $id)
        ->get();
        $arrKelas = [];
        $arrKelasName = [];
        foreach($kelas as $value){
            array_push($arrKelas, $value->id_kelas);
            array_push($arrKelasName, $value->detail->name);
        }

        $data = [
            'kelas' => $arrKelas,
            'name' => $arrKelasName
        ];

        if($kelas){
            return ['status' => 'success', 'data' => $data, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function detailClass($id){
        $detail = Kelas::where('id', $id)->first();

        if($detail){
            return ['status' => 'success', 'data' => $detail, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }
}
