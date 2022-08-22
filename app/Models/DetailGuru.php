<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailGuru extends Model
{
    use HasFactory;

    protected $table = 'detail_guru';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_guru',
        'pendidikan_terakhir',
    ];
}
