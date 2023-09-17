<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Ujian;
use App\Models\NilaiSiswa;
use App\Models\HasilUjian;

class ExamResultController extends Controller
{
    public function getStudentScore(Request $request){
        $ujian = Ujian::where([
            'id_kelas' => $request->id_kelas,
            'id_mapel' => $request->id_mapel,
        ])->get();

        if($ujian){
            return ['status' => 'success', 'data' => $ujian, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getStudentScoreDetail(Request $request){
        $ujian = Ujian::with([
            'nilai' => function($q){
                $q->with([
                    'siswa' => function($q){
                        $q->select('id', 'nama');
                    }
                ])->select('id_ujian', 'id_siswa', 'nilai',);
            },
            'mapel' => function($q){
                $q->select('id', 'name');
            }
        ])
        ->where('id', $request->id_ujian)
        ->get();

        if($ujian){
            return ['status' => 'success', 'data' => $ujian, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function correctStudentAnswer(Request $request){
        $ujian = Ujian::with([
            'pg' => function($q){
                $q->with([
                    'detail' => function($q){
                        $q->select('id_soal','name');
                    }
                ])
                ->select(
                    'id',
                    'id_ujian',
                    'id_jenis_soal',
                    'pertanyaan',
                    'pilihan_a',
                    'pilihan_b',
                    'pilihan_c',
                    'pilihan_d',
                    'jawaban',
                );
            },
            'essay' => function($q){
                $q->with([
                    'detail' => function($q){
                        $q->select('id_soal','name');
                    }
                ])->select(
                    'id',
                    'id_ujian',
                    'id_jenis_soal',
                    'pertanyaan',
                    'jawaban',
                );
            }
        ])
        ->where('id', $request->id_ujian)
        ->first();

        if($ujian){
            return ['status' => 'success', 'data' => $ujian, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getDetailScore(Request $request){
        $nilai = NilaiSiswa::where([
            'id_ujian' => $request->id_ujian,
            'id_siswa' => $request->id_siswa,
        ])->first();

        if($nilai){
            return ['status' => 'success', 'data' => $nilai, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getDetailAnswer(Request $request){
        $result = HasilUjian::where([
            'id_ujian' => $request->id_ujian,
            'id_siswa' => $request->id_siswa,
            'id_soal' => $request->id_soal,
        ])->first();

        if($result){
            return ['status' => 'success', 'data' => $result, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function updateDetailAnswer(Request $request){
        $result = HasilUjian::where([
            'id_ujian' => $request->id_ujian,
            'id_siswa' => $request->id_siswa,
            'id_soal' => $request->id_soal,
        ])->first();
        $result->koreksi_jawaban = $request->koreksi_jawaban;
        $result->save();

        if($result){
            return ['status' => 'success', 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }
    public function updateStudentScore(Request $request){
        $score = NilaiSiswa::where([
            'id_ujian' => $request->id_ujian,
            'id_siswa' => $request->id_siswa,
        ])->first();
        $score->nilai = $request->nilai;
        $score->save();

        if($score){
            return ['status' => 'success', 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }
}
