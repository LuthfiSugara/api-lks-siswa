<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Ujian;
use App\models\Soal;
use App\models\DetailSoal;
use App\models\HasilUjian;
use App\models\NilaiSiswa;
use App\models\LocationExam;

class ExamController extends Controller
{
    public function createExam(Request $request){
        $ujian = new Ujian;
        $ujian->name = $request->name;
        $ujian->id_jenis_ujian = $request->id_jenis_ujian;
        $ujian->id_mapel = $request->id_mapel;
        $ujian->id_kelas = $request->id_kelas;
        $ujian->id_guru = $request->id_guru;
        $ujian->from = $request->from;
        $ujian->to = $request->to;
        $ujian->save();

        if($ujian){
            return ['status' => 'success', 'data' => $ujian, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function detailExam(Request $request){
        $ujian = Ujian::where('id', $request->id)->get();

        if($ujian){
            return ['status' => 'success', 'data' => $ujian, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function updateExam(Request $request, $id){
        // return $request->all();
        $ujian = Ujian::where('id', $id)->first();
        $ujian->name = $request->name;
        $ujian->id_mapel = $request->id_mapel;
        $ujian->id_kelas = $request->id_kelas;
        $ujian->id_guru = $request->id_guru;
        $ujian->from = $request->from;
        $ujian->to = $request->to;
        $ujian->save();

        if($ujian){
            return ['status' => 'success', 'data' => $ujian, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function createExamQuestions(Request $request){

        $soal = new Soal;
        if($request->id_jenis_soal == 1){
            $soal->id_ujian = $request->id_ujian;
            $soal->id_jenis_soal = $request->id_jenis_soal;
            $soal->pertanyaan = $request->pertanyaan;
            $soal->pilihan_a = $request->pilihan_a;
            $soal->pilihan_b = $request->pilihan_b;
            $soal->pilihan_c = $request->pilihan_c;
            $soal->pilihan_d = $request->pilihan_d;
            $soal->jawaban = $request->jawaban;
            $soal->save();
        }else{
            $soal->id_ujian = $request->id_ujian;
            $soal->id_jenis_soal = $request->id_jenis_soal;
            $soal->pertanyaan = $request->pertanyaan;
            $soal->jawaban = $request->jawaban;
            $soal->save();
        }

        if ($request->file) {
            $j = 0;
            foreach($request->file as $value){
                $file_name = '/assets/soal/' . $soal->pertanyaan . '-' . $soal->id_ujian . '-' . $j . '-' . time() . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('/assets/soal/'), $file_name);

                $detail = new DetailSoal;
                $detail->name = $file_name;
                $detail->id_soal = $soal->id;
                $detail->save();

                $j++;
            }
        }

        if($soal){
            return ['status' => 'success', 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getAllExamBaseOnType(Request $request){
        $exams = new Ujian();
        $exams = $exams->with([
            'kelas' => function($q){
                $q->select('id', 'name');
            },
            'mapel' => function($q){
                $q->select('id', 'name');
            },
            'guru' => function($q){
                $q->select('id', 'nama');
            },
        ])
        ->orderBy('created_at', 'asc')
        ->where('id_jenis_ujian', $request->type);

        if($request->id_mapel != "All"){
            $exams = $exams->where('id_mapel', $request->id_mapel);
        }

        if($request->id_kelas != "All"){
            $exams = $exams->where('id_kelas', $request->id_kelas);
        }

        if($request->id_guru != "All"){
            $exams = $exams->where('id_guru', $request->id_guru);
        }

        $exams = $exams->get();

        if($exams){
            return ['status' => 'success', 'data' => $exams, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getExamQuestions(Request $request){
        $questions = Soal::with([
            'ujian' => function($q){
                $q->with(['jenis_ujian:id,name', 'mapel:id,name', 'kelas:id,name', 'guru:id,nama'])->select('id', 'id_jenis_ujian', 'id_mapel', 'id_kelas', 'id_guru', 'from', 'to');
            },
            'detail' => function($q){
                $q->select('id', 'id_soal', 'name');
            },
            'result' => function($q){
                $q->select('id', 'id_siswa', 'id_ujian', 'id_soal', 'jawaban_siswa', 'koreksi_jawaban',);
            }
        ])
        ->where('id_ujian', $request->id)
        ->where('id_jenis_soal', $request->type)
        ->orderBy('id', 'asc')
        ->get();

        if($questions){
            return ['status' => 'success', 'data' => $questions, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function detailQuestion(Request $request){
        $question = Soal::with([
            'ujian' => function($q){
                $q->with(['jenis_ujian:id,name', 'mapel:id,name', 'kelas:id,name', 'guru:id,nama'])->select('id', 'id_jenis_ujian', 'id_mapel', 'id_kelas', 'id_guru', 'from', 'to');
            },
            'detail' => function($q){
                $q->select('id', 'id_soal', 'name');
            }
        ])
        ->where('id', $request->id)
        ->get();

        if($question){
            return ['status' => 'success', 'data' => $question, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function updateQuestion(Request $request, $id){
        $question = Soal::where('id', $id)->first();
        if($question->id_jenis_soal == 1){
            $question->pertanyaan = $request->pertanyaan;
            $question->pilihan_a = $request->pilihan_a;
            $question->pilihan_b = $request->pilihan_b;
            $question->pilihan_c = $request->pilihan_c;
            $question->pilihan_d = $request->pilihan_d;
            $question->jawaban = $request->jawaban;
            $question->save();
        }else{
            $question->pertanyaan = $request->pertanyaan;
            $question->jawaban = $request->jawaban;
            $question->save();
        }

        if ($request->file) {
            $j = 0;
            foreach($request->file as $value){
                $file_name = '/assets/soal/' . $request->pertanyaan . '-' . $question->id_ujian . '-' . $j . '-' . time() . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('/assets/soal/'), $file_name);

                $detail = new DetailSoal;
                $detail->name = $file_name;
                $detail->id_soal = $question->id;
                $detail->save();

                $j++;
            }
        }

        if($question){
            return ['status' => 'success', 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function deleteExam($id){
        $delete = Ujian::where('id', $id)->delete();

        if($delete){
            return ['status' => 'success', 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function deleteFileExam($id){
        $delete = DetailSoal::where('id', $id)->delete();

        if($delete){
            return ['status' => 'success', 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function createExamResults(Request $request){
        $soal = Soal::where('id_ujian', $request->id_ujian)->get();
        foreach($soal as $value){
            $checkQuestionExist = HasilUjian::where([
                'id_siswa' => $request->id_siswa,
                'id_ujian' => $request->id_ujian,
                'id_soal' => $value->id,
            ])->first();

            if(!$checkQuestionExist){
                $create = new HasilUjian;
                $create->id_siswa = $request->id_siswa;
                $create->id_ujian = $request->id_ujian;
                $create->id_soal = $value->id;
                $create->save();
            }
        }

        return ['status' => 'success', 'message' => 'Success'];
    }

    public function getExamResults($id_ujian, $id_siswa){
        $examResults = HasilUjian::with([
            'soal' => function($q){
                $q->select('id', 'id_ujian', 'id_jenis_soal', 'pertanyaan', 'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'jawaban',);
            }
        ])
        ->where([
            'id_ujian' => $id_ujian,
            'id_siswa' => $id_siswa,
        ])->get();

        if($examResults){
            return ['status' => 'success', 'data' => $examResults, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getExamResultsAnswer(Request $request){
        $answer = HasilUjian::where([
            'id_siswa' => $request->id_siswa,
            'id_ujian' => $request->id_ujian,
            'id_soal' => $request->id_soal,
        ])->first();

        if($answer){
            return ['status' => 'success', 'data' => $answer, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function updateExamResultsAnswer(Request $request, $id_siswa, $id_ujian, $id_soal){

        $update = HasilUjian::where([
            'id_siswa' => $id_siswa,
            'id_ujian' => $id_ujian,
            'id_soal' => $id_soal,
        ])->first();

        $update->jawaban_siswa = $request->jawaban_siswa;
        $update->save();

        $nilai = NilaiSiswa::where([
            'id_ujian' => $id_ujian,
            'id_siswa' => $id_siswa,
            ])->first();

        $ujian = Ujian::where('id', $id_ujian)->first();
        $hasil = 0.0;
        if($ujian->id_jenis_ujian != 4){
            $soal = Soal::where([
                'id_ujian' => $id_ujian,
                'id_jenis_soal' => 1,
            ])
            ->get();
            $jawabanBenar = 0;
            foreach($soal as $value){
                $answer = HasilUjian::where([
                    'id_siswa' => $id_siswa,
                    'id_ujian' => $id_ujian,
                    'id_soal' => $value->id,
                ])->first();
                if($value->jawaban == $answer->jawaban_siswa){
                    $jawabanBenar += 1;
                }
            }

            $hasil = ($jawabanBenar / count($soal)) * 100;
        }

        if(!$nilai){
            $create = new NilaiSiswa;
            $create->id_ujian = $id_ujian;
            $create->id_siswa = $id_siswa;
            $create->nilai = $hasil;
            $create->save();
        }else{
            $update = NilaiSiswa::where([
                'id_ujian' => $id_ujian,
                'id_siswa' => $id_siswa,
            ])->first();
            $update->nilai = $hasil;
            $update->save();
        }

        if($update){
            return ['status' => 'success', 'data' => $update, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function createLocationExam(Request $request){
        $checkLocation = LocationExam::where([
            'id_ujian' => $request->id_ujian,
            'id_siswa' => $request->id_siswa,
            'id_location' => $request->id_location,
        ])->first();

        if($checkLocation){
            return ['status' => 'success', 'data' => $checkLocation, 'message' => 'Success'];
        }else{
            $createLocation = LocationExam::create([
                'id_ujian' => $request->id_ujian,
                'id_siswa' => $request->id_siswa,
                'id_location' => $request->id_location,
            ]);
        }


        if($createLocation){
            return ['status' => 'success', 'data' => $createLocation, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getLocationExam(Request $request){
        $location = LocationExam::with('detail')
        ->where([
            'id_ujian' => $request->id_ujian,
            'id_siswa' => $request->id_siswa,
        ])
        ->orderBy('created_at', 'desc')
        ->first();

        if($location){
            return ['status' => 'success', 'data' => $location, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }
}
