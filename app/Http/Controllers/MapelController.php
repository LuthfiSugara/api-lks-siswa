<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\MataPelajaran;

class MapelController extends Controller
{
    public function detailMapel($id){
        $detail = MataPelajaran::where('id', $id)->first();

        if($detail){
            return ['status' => 'success', 'data' => $detail, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }
}
