<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasilUjian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hasil_ujian';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'id_ujian',
        'id_soal',
        'jawaban_siswa',
        'koreksi_jawaban',
    ];

    public function soal(){
        return $this->belongsTo(Soal::class, 'id_soal', 'id');
    }
}
