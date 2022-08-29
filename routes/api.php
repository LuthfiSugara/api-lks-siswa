<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ClassController;

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
    Route::get('detail-user/{id}', [UserController::class, 'detailUser']);
    Route::post('edit-user/{id}', [UserController::class, 'editUser']);

    Route::get('all-user', [UserController::class, 'getAllUser']);
    Route::get('all-admin', [UserController::class, 'getAllAdmin']);
    Route::get('all-guru', [UserController::class, 'getAllGuru']);
    Route::get('all-siswa', [UserController::class, 'getAllSiswa']);

    Route::get('get-teacher-by-class-id/{idKelas}/{idMapel}', [UserController::class, 'getTeacherByClassId']);

    Route::get('kelas', [SettingController::class, 'kelas']);
    Route::post('add-kelas', [SettingController::class, 'addKelas']);
    Route::post('edit-kelas/{id}', [SettingController::class, 'editKelas']);
    Route::get('get-class-by-teacher-id/{id}', [ClassController::class, 'getCLassByTeacherId']);

    Route::get('jenis-kelamin', [SettingController::class, 'jenisKelamin']);

    Route::get('jabatan', [SettingController::class, 'jabatan']);
    Route::post('add-jabatan', [SettingController::class, 'addJabatan']);

    Route::get('all-mapel', [SettingController::class, 'allMataPelajaran']);
    Route::post('add-mapel', [SettingController::class, 'addMataPelajaran']);
    Route::post('edit-mapel/{id}', [SettingController::class, 'editMataPelajaran']);

    Route::post('add-materi', [MateriController::class, 'addMateri']);

});

