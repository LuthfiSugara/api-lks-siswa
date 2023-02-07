<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamResultController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('register', [UserController::class, 'register']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('detail-user', [UserController::class, 'detailUser']);
    Route::post('edit-user', [UserController::class, 'editUser']);

    Route::get('all-user', [UserController::class, 'getAllUser']);
    Route::get('all-admin', [UserController::class, 'getAllAdmin']);
    Route::get('all-guru', [UserController::class, 'getAllGuru']);
    Route::get('all-siswa', [UserController::class, 'getAllSiswa']);

    Route::get('get-teacher-by-class-id', [UserController::class, 'getTeacherByClassId']);

    Route::get('kelas', [SettingController::class, 'kelas']);
    Route::post('add-kelas', [SettingController::class, 'addKelas']);
    Route::post('edit-kelas/{id}', [SettingController::class, 'editKelas']);
    Route::get('get-class-by-teacher-id', [ClassController::class, 'getCLassByTeacherId']);
    Route::get('detail-kelas/{id}', [ClassController::class, 'detailClass']);

    Route::get('jenis-kelamin', [SettingController::class, 'jenisKelamin']);

    Route::get('jabatan', [SettingController::class, 'jabatan']);
    Route::post('add-jabatan', [SettingController::class, 'addJabatan']);

    Route::get('all-mapel', [SettingController::class, 'allMataPelajaran']);
    Route::post('add-mapel', [SettingController::class, 'addMataPelajaran']);
    Route::post('edit-mapel/{id}', [SettingController::class, 'editMataPelajaran']);
    Route::get('detail-mapel/{id}', [MapelController::class, 'detailMapel']);

    Route::get('materi', [MateriController::class, 'getMateri']);
    Route::get('detail-materi', [MateriController::class, 'detailMateri']);
    Route::post('add-materi', [MateriController::class, 'addMateri']);
    Route::post('update-materi', [MateriController::class, 'updateMateri']);
    Route::get('delete-detail-file-materi/{id}', [MateriController::class, 'deleteDetailFileMateri']);

    Route::post('create-exam', [ExamController::class, 'createExam']);
    Route::get('detail-exam', [ExamController::class, 'detailExam']);
    Route::post('update-exam/{id}', [ExamController::class, 'updateExam']);
    Route::post('create-exam-questions', [ExamController::class, 'createExamQuestions']);
    Route::get('get-exam-questions', [ExamController::class, 'getExamQuestions']);
    Route::get('get-all-exam-base-on-type', [ExamController::class, 'getAllExamBaseOnType']);
    Route::get('delete-exam/{id}', [ExamController::class, 'deleteExam']);
    Route::post('create-location-exam', [ExamController::class, 'createLocationExam']);
    Route::get('get-location-exam', [ExamController::class, 'getLocationExam']);

    Route::get('detail-question', [ExamController::class, 'detailQuestion']);
    Route::post('update-question/{id}', [ExamController::class, 'updateQuestion']);
    Route::get('delete-file-exam/{id}', [ExamController::class, 'deleteFileExam']);

    Route::post('create-exam-results', [ExamController::class, 'createExamResults']);
    Route::get('get-exam-results/{id_ujian}/{id_siswa}', [ExamController::class, 'getExamResults']);
    Route::get('get-exam-results-answer', [ExamController::class, 'getExamResultsAnswer']);
    Route::post('update-exam-results-answer/{id_siswa}/{id_ujian}/{id_soal}', [ExamController::class, 'updateExamResultsAnswer']);

    Route::get('student-score', [ExamResultController::class, 'getStudentScore']);
    Route::get('student-score-detail', [ExamResultController::class, 'getStudentScoreDetail']);

    Route::get('correct-student-answer', [ExamResultController::class, 'correctStudentAnswer']);
    Route::get('detail-score', [ExamResultController::class, 'getDetailScore']);
    Route::get('detail-answer', [ExamResultController::class, 'getDetailAnswer']);
    Route::post('update-detail-answer', [ExamResultController::class, 'updateDetailAnswer']);
    Route::post('update-student-score', [ExamResultController::class, 'updateStudentScore']);

});

