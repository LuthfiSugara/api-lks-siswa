<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKelasUser extends Model
{
    use HasFactory;

    protected $table = 'detail_kelas_user';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_kelas',
        'id_jabatan',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
