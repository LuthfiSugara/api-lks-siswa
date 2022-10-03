<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_soal';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'name',
    ];
}
