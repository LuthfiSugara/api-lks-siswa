<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailMateri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_materi';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'name',
        'id_materi',
    ];
}
