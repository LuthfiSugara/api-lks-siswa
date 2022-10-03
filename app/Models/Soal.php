<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'soal';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_ujian',
        'id_jenis_soal',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban',
    ];

    public function ujian(){
        return $this->belongsTo(Ujian::class, 'id_ujian', 'id');
    }

    public function detail(){
        return $this->hasMany(DetailSoal::class, 'id_soal', 'id');
    }

    public function result(){
        return $this->belongsTo(HasilUjian::class, 'id', 'id_soal');
    }

}
