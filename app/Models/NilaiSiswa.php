<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nilai_siswa';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_ujian',
        'id_siswa',
        'nilai',
    ];

    public function siswa(){
        return $this->belongsTo(User::class, 'id_siswa', 'id');
    }
}
