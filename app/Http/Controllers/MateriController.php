<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Materi;
use App\models\DetailMateri;
use App\models\MataPelajaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MateriController extends Controller
{
    public function getMateri(Request $request){
        $materi = Materi::with([
            'mapel' => function($q){
                $q->select('id', 'name');
            },
            'kelas' => function($q){
                $q->select('id', 'name');
            },
            'guru' => function($q){
                $q->select('id', 'nama');
            }
        ])
        ->orderBy('id', 'asc')->where([
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'id_guru' => $request->id_guru,
        ])->get();

        if($materi){
            return ['status' => "success", 'data' => $materi, 'message' => 'Success'];
        }else{
            return ['status' => "fail", 'message' => 'Failed'];
        }
    }

    public function detailMateri(Request $request){
        $materi = Materi::with([
            'mapel' => function($q){
                $q->select('id', 'name');
            },
            'kelas' => function($q){
                $q->select('id', 'name');
            },
            'guru' => function($q){
                $q->select('id', 'nama');
            },
            'detail' => function($q){
                $q->select('id', 'name', 'id_materi');
            }
        ])
        ->orderBy('id', 'asc')
        ->where('id', $request->id_materi)
        ->first();

        if($materi){
            return ['status' => "success", 'data' => $materi, 'message' => 'Success'];
        }else{
            return ['status' => "fail", 'message' => 'Failed'];
        }
    }

    public function addMateri(Request $request){
        $materi = new Materi;
        $materi->judul = $request->judul;
        $materi->keterangan = $request->keterangan;
        $materi->id_mapel = $request->id_mapel;
        $materi->id_kelas = $request->id_kelas;
        $materi->id_guru = $request->id_guru;
        $materi->save();

        if ($request->file) {
            $mapel = MataPelajaran::where('id', $request->id_mapel)->first();
            $j = 0;
            foreach($request->file as $value){
                $file_name = '/assets/materi/' . $mapel->name . '-' . $materi->judul . '-' . $j . '-' . time() . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('/assets/materi/'), $file_name);

                $detail = new DetailMateri;
                $detail->name = $file_name;
                $detail->id_materi = $materi->id;
                $detail->save();

                $j++;
            }
        }
        return ['status' => "success", 'message' => 'Success'];
    }

    public function updateMateri(Request $request){
        $materi = Materi::where('id', $request->id)->first();
        $materi->judul = $request->judul;
        $materi->keterangan = $request->keterangan;
        $materi->save();

        if ($request->file) {
            $mapel = MataPelajaran::where('id', $materi->id_mapel)->first();
            $j = 0;
            foreach($request->file as $value){
                $file_name = '/assets/materi/' . $mapel->name . '-' . $materi->judul . '-' . $j . '-' . time() . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('/assets/materi/'), $file_name);

                $detail = new DetailMateri;
                $detail->name = $file_name;
                $detail->id_materi = $materi->id;
                $detail->save();

                $j++;
            }
        }
        return ['status' => "success", 'message' => 'Success'];
    }

    public function deleteDetailFileMateri($id){
        $delete = DetailMateri::where('id', $id)->delete();

        if($delete){
            return ['status' => "success", 'message' => 'Success'];
        }else{
            return ['status' => "fail", 'message' => 'Failed'];
        }
    }
}
