<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailSoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_soal';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_soal',
        'name',
    ];
}
