<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Ujian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ujian';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'name',
        'id_jenis_ujian',
        'id_mapel',
        'id_kelas',
        'id_guru',
        'from',
        'to',
    ];

    protected $appends = ['can_start'];



    public function jenis_ujian(){
        return $this->belongsTo(JenisUjian::class, 'id_jenis_ujian', 'id');
    }

    public function mapel(){
        return $this->belongsTo(MataPelajaran::class, 'id_mapel', 'id');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function guru(){
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }

    public function nilai(){
        return $this->hasMany(NilaiSiswa::class, 'id_ujian', 'id');
    }

    public function pg(){
        return $this->hasMany(Soal::class, 'id_ujian', 'id')->where('id_jenis_soal', 1);
    }

    public function essay(){
        return $this->hasMany(Soal::class, 'id_ujian', 'id')->where('id_jenis_soal', 2);
    }

    public function getCanStartAttribute(){
        $from = Carbon::parse($this->from, 'Asia/Jakarta');
        $to = Carbon::parse($this->to, 'Asia/Jakarta');
        $now = Carbon::now();
         $diffFrom = $now->diffInMilliseconds($from, false);
        $diffTo = $now->diffInMilliseconds($to, false);

        if($diffFrom < 0 && $diffTo > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getFromAttribute($value){
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $value, 'Asia/Jakarta');
        $date->setTimezone('UTC');
        return $date;
    }

    public function getToAttribute($value){
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $value, 'Asia/Jakarta');
        $date->setTimezone('UTC');
        return $date;
    }

}
