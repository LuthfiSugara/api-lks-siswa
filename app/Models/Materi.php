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
}
