<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'materi';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'judul',
        'keterangan',
        'id_mapel',
        'id_kelas',
        'id_guru',
    ];

    public function mapel(){
        return $this->belongsTo(MataPelajaran::class, 'id_mapel', 'id');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function guru(){
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }

    public function detail_image(){
        return $this->hasMany(DetailMateri::class, 'id_materi', 'id')->where('type', 1);
    }

    public function detail_video(){
        return $this->hasMany(DetailMateri::class, 'id_materi', 'id')->where('type', 2);
    }
}
