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
                $file_name = '/assets/materi/' . $mapel->name . '-' . $materi->judul . '-' . time() . '.' . $request->file[$j]->getClientOriginalExtension();
                $request->file[$j]->move(public_path('/assets/materi/'), $file_name);

                DetailMateri::create([
                    'name' => $file_name,
                    'id_materi' => $materi->id,
                ]);
                $j++;
            }
        }
        return ['status' => "success", 'message' => 'Success'];
    }
}
