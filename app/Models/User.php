<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'nama_lengkap',
        'username',
        'password',
        'tanggal_lahir',
        'foto',
        'no_hp',
        'id_jenis_kelamin',
        'id_jabatan',
        'id_kelas',
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
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id');
    }

    public function jenis_kelamin(){
        return $this->belongsTo(JenisKelamin::class, 'id_jenis_kelamin', 'id');
    }

    public function getTanggalLahirAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

}
