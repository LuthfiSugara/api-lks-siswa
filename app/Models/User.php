<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nama',
        'username',
        'password',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto',
        'no_hp',
        'id_jenis_kelamin',
        'id_jabatan',
        'id_mapel',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function kelas(){
        return $this->hasMany(DetailKelasUser::class, 'id_user', 'id');
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id');
    }

    public function jenis_kelamin(){
        return $this->belongsTo(JenisKelamin::class, 'id_jenis_kelamin', 'id');
    }

    public function pendidikan(){
        return $this->belongsTo(DetailGuru::class, 'id', 'id_guru');
    }

    public function mapel(){
        return $this->belongsTo(MataPelajaran::class, 'id_mapel', 'id');
    }

    // public function getTanggalLahirAttribute($value) {
    //     // return $value . ' 00:00:00';
    //     $date = Carbon::createFromFormat('Y-m-d H:i:s', $value  . ' 00:00:00', 'Asia/Jakarta');
    //     $date->setTimezone('UTC');
    //     return $date;
    // }


}
