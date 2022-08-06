<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Helper\UserService;
use App\models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make(['username' => $request->username],
            [
                'username' => ['unique:users']
            ]
        );

        if($validator->fails()){
            return ['status' => "fail", 'message' => 'Username sudah terdaftar'];
        }else{
            $foto = $request->foto;
            $file_name = 'assets/images/example.png';
            if ($foto) {
                $file_name = '/assets/images/' . 'foto_profile_' . time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('/assets/images/'), $file_name);
            }

            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'tanggal_lahir' => $request->tanggal_lahir,
                'foto' => $file_name,
                'no_hp' => $request->no_hp,
                'id_jenis_kelamin' => $request->id_jenis_kelamin,
                'id_jabatan' => $request->id_jabatan,
                'id_kelas' => $request->id_kelas,
            ]);
            return ['status' => 'success', 'message' => 'Registrasi berhasil'];
        }
    }

    public function login(Request $request){
        $user = User::
        with([
            'kelas' => function($q){
                $q->select('id', 'name');
            },
            'jabatan' => function($q){
                $q->select('id', 'name');
            },
            'jenis_kelamin' => function($q){
                $q->select('id', 'name');
            }
        ])
        ->where('username', $request->username)
        ->first();

        if(!$user){
            return ['status' => "fail", 'message' => 'Email atau Password Salah'];
        }else{
            if($user && Hash::check($request->password, $user->password)){
                $token = $user->createToken($request->device_name)->plainTextToken;
                return ['status' => "success", 'access_token' => $token, 'data' => $user];
            }else{
                return ['status' => "fail", 'message' => 'Password Salah'];
            }
        }
    }

    public function profile(Request $request){
        $id = $request->user()->id;

        $user = User::
        with([
            'kelas' => function($q){
                $q->select('id', 'name');
            },
            'jabatan' => function($q){
                $q->select('id', 'name');
            },
            'jenis_kelamin' => function($q){
                $q->select('id', 'name');
            }
        ])
        ->where('id', $id)
        ->first();

        if($user){
            return ['status' => 'success', 'data' => $user, 'message' => 'Data berhasil didapat'];
        }else{
            return ['status' => 'fail', 'message' => 'Data gagal didapat'];
        }
    }

    public function detailUser($id){
        $user = User::
        with([
            'kelas' => function($q){
                $q->select('id', 'name');
            },
            'jabatan' => function($q){
                $q->select('id', 'name');
            },
            'jenis_kelamin' => function($q){
                $q->select('id', 'name');
            }
        ])
        ->where('id', $id)
        ->first();

        if($user){
            return ['status' => 'success', 'data' => $user, 'message' => 'Data berhasil didapat'];
        }else{
            return ['status' => 'fail', 'message' => 'Data gagal didapat'];
        }
    }

    public function getAllUser(){
        $user = User::get();
        return ['status' => 'success', 'data' => $user, 'message' => 'Data berhasil didapat'];
    }

    public function editUser($id, Request $request){

        $user = User::where('id', $id)->first();
        $file_name = $user->foto;

        $validationUsername = User::whereNotIn('username', [$user->username])->get();
        foreach($validationUsername as $value){
            if(strtolower($value->username) === strtolower($request->username)){
                return ['status' => "fail", 'message' => 'Username sudah digunakan'];
            }
        }

        $foto = $request->foto;
        if ($foto) {
            $file_name = '/assets/images/' . 'foto_profile_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('/assets/images/'), $file_name);
        }

        $arrDate = explode("/", $request->tanggal_lahir);
        if(strlen($arrDate[2]) >= 3){
            $tanggal_lahir = $arrDate[2] . '/' . $arrDate[1] . '/' . $arrDate[0];
        }else{
            $tanggal_lahir = Carbon::parse($request->tanggal_lahir)->format('Y/m/d');
        }

        if($request->password){
            $user->nama_lengkap = $request->nama_lengkap;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->tanggal_lahir = $tanggal_lahir;
            $user->foto = $file_name;
            $user->no_hp = $request->no_hp;
            $user->id_jenis_kelamin = $request->id_jenis_kelamin;
            $user->id_jabatan = $request->id_jabatan;
            $user->id_kelas = $request->id_kelas;
            $user->save();

            return ['status' => 'success', 'message' => 'Berhasil Mengubah Data'];
        }else{
            $user->nama_lengkap = $request->nama_lengkap;
            $user->username = $request->username;
            $user->tanggal_lahir = $tanggal_lahir;
            $user->foto = $file_name;
            $user->no_hp = $request->no_hp;
            $user->id_jenis_kelamin = $request->id_jenis_kelamin;
            $user->id_jabatan = $request->id_jabatan;
            $user->id_kelas = $request->id_kelas;
            $user->save();

            return ['status' => 'success', 'message' => 'Berhasil Mengubah Data'];
        }


    }
}

