<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;

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

    Route::get('kelas', [SettingController::class, 'kelas']);
    Route::get('jenis-kelamin', [SettingController::class, 'jenisKelamin']);
    Route::get('jabatan', [SettingController::class, 'jabatan']);
});

