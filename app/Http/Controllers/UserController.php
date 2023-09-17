<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Helper\UserService;
use App\models\User;
use App\models\DetailGuru;
use App\models\DetailSiswa;
use App\models\DetailKelasUser;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
            $file_name = '/assets/images/example.png';
            if ($foto) {
                $file_name = '/assets/images/' . 'foto_profile_' . time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('/assets/images/'), $file_name);
            }

            $user = new User;
            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->tempat_lahir = $request->tempat_lahir;
            $user->foto = $file_name;
            $user->no_hp = $request->no_hp;
            $user->alamat = $request->alamat;
            $user->id_jenis_kelamin = $request->id_jenis_kelamin;
            $user->id_jabatan = $request->id_jabatan;
            if($request->id_mapel){
                $user->id_mapel = $request->id_mapel;
            }
            $user->save();


            if($request->id_jabatan == 2){
                $detail = new DetailGuru;
                $detail->id_guru = $user->id;
                $detail->pendidikan_terakhir = $request->pendidikan_terakhir;
                $detail->save();

                $arrKelas = $request->id_kelas;
                if(!is_array($request->id_kelas)){
                    $arrKelas = explode(",", $request->id_kelas);
                }

                for($i = 0; $i < count($arrKelas); $i++){
                    $kelas = new DetailKelasUser();
                    $kelas->id_user = $user->id;
                    $kelas->id_kelas = $arrKelas[$i];
                    $kelas->id_jabatan = $user->id_jabatan;
                    $kelas->id_mapel = $user->id_mapel;
                    $kelas->save();
                }
            }elseif($request->id_jabatan == 3){
                $detail = new DetailSiswa;
                $detail->id_siswa = $user->id;
                $detail->nama_ayah = $request->nama_ayah;
                $detail->nama_ibu = $request->nama_ibu;
                $detail->pekerjaan_ayah = $request->pekerjaan_ayah;
                $detail->pekerjaan_ibu = $request->pekerjaan_ibu;
                $detail->save();

                $kelas = new DetailKelasUser();
                $kelas->id_user = $user->id;
                $kelas->id_kelas = $request->id_kelas;
                $kelas->id_jabatan = $user->id_jabatan;
                $kelas->save();
            }

            return ['status' => 'success', 'message' => 'Registrasi berhasil'];
        }
    }

    public function login(Request $request){
        $user = User::
        with([
            'kelas' => function($q){
                $q->select('id', 'id_user', 'id_kelas');
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
            return ['status' => "fail", 'message' => 'Username atau Password Salah'];
        }else{
            if($user && Hash::check($request->password, $user->password)){
                $token = $user->createToken('android')->plainTextToken;
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
            'jabatan' => function($q){
                $q->select('id', 'name');
            },
            'jenis_kelamin' => function($q){
                $q->select('id', 'name');
            },
            'kelas' => function($q){
                $q->with([
                    'detail' =>  function($q){
                        $q->select('id', 'name');
                    }
                ])->select('id', 'id_user', 'id_kelas', 'id_jabatan');
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

    public function detailUser(Request $request){
        $user = User::
        with([
            'kelas' => function($q){
                $q->with(['detail:id,name'])->select('id_user', 'id_kelas');
            },
            'jabatan' => function($q){
                $q->select('id', 'name');
            },
            'jenis_kelamin' => function($q){
                $q->select('id', 'name');
            },
            'pendidikan' => function($q){
                $q->select('id', 'id_guru', 'pendidikan_terakhir');
            },
            'mapel' => function($q){
                $q->select('id', 'name');
            },
            'siswa' => function($q){
                $q->select('id_siswa', 'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu');
            }
        ])
        ->where('id', $request->id)
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

    public function editUser(Request $request){
        $user = User::where('id', $request->id)->first();

        $validateUsername = User::whereNotIn('username', [$user->username])->get();
        foreach($validateUsername as $value){
            if($value->username === $request->username){
                return ['status' => "fail", 'message' => 'Username sudah digunakan'];
            }
        }

        $foto = $request->foto;
        $file_name = $user->foto;
        if ($foto) {
            $file_name = '/assets/images/' . 'foto_profile_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('/assets/images/'), $file_name);
        }

        $user->nama = $request->nama;
        $user->username = $request->username;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->foto = $file_name;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->id_jenis_kelamin = $request->id_jenis_kelamin;
        if($user->id_jabatan == 2){
            $user->id_mapel = $request->id_mapel;
        }
        $user->save();


        if($user->id_jabatan == 2){
            DB::table('detail_guru')
            ->where('id_guru', $request->id)
            ->update([
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'updated_at' => Carbon::now()
            ]);

            DB::table('detail_kelas_user')->where('id_user', $request->id)->delete();

            $arrKelas = $request->id_kelas;
            if(!is_array($request->id_kelas)){
                $arrKelas = explode(",", $request->id_kelas);
            }

            for($i = 0; $i < count($arrKelas); $i++){
                DB::table('detail_kelas_user')->insert([
                    'id_user' => $user->id,
                    'id_kelas' => $arrKelas[$i],
                    'id_jabatan' => $user->id_jabatan,
                    'id_mapel' => $request->id_mapel,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }elseif($user->id_jabatan == 3){
            DB::table('detail_siswa')
            ->where('id_siswa', $request->id)
            ->update([
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'updated_at' => Carbon::now(),
            ]);

            DB::table('detail_kelas_user')
            ->where('id_user', $request->id)
            ->update([
                'id_kelas' => $request->id_kelas,
                'updated_at' => Carbon::now(),
            ]);
        }

        return ['status' => 'success', 'message' => 'Success'];
    }

    public function getAllAdmin(){
        $admin = User::where('id_jabatan', 1)->get();

        if($admin){
            return ['status' => 'success', 'data' => $admin, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getAllGuru(){
        $guru = User::with([
            'kelas' => function($q){
                $q->with(['detail:id,name'])->select('id_user', 'id_kelas');
            },
            'jabatan' => function($q){
                $q->select('id', 'name');
            },
            'jenis_kelamin' => function($q){
                $q->select('id', 'name');
            },
            'pendidikan' => function($q){
                $q->select('id', 'id_guru', 'pendidikan_terakhir');
            },
            'mapel' => function($q){
                $q->select('id', 'name');
            }
        ])
        ->where('id_jabatan', 2)
        ->get();

        if($guru){
            return ['status' => 'success', 'data' => $guru, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getAllSiswa(){
        $siswa = User::with([
            'kelas' => function($q){
                $q->with(['detail:id,name'])->select('id_user', 'id_kelas');
            },
        ])
        ->where('id_jabatan', 3)
        ->get();

        if($siswa){
            return ['status' => 'success', 'data' => $siswa, 'message' => 'Success'];
        }else{
            return ['status' => 'fail', 'message' => 'Failed'];
        }
    }

    public function getTeacherByClassId(Request $request){
        $guru = DetailKelasUser::with([
            'user' => function($q){
                $q->select('id', 'nama');
            }
        ])
        ->where([
            'id_kelas' => $request->id_kelas,
            'id_mapel' => $request->id_mapel,
            'id_jabatan' => 2,
        ])
        ->get();

        return ['status' => 'success', 'data' => $guru, 'message' => 'Success'];
    }
}

