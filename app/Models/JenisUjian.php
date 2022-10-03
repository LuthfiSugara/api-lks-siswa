<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisUjian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_ujian';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'name',
    ];
}
