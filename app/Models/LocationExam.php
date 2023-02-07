<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationExam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'location_exam';
    protected $parimaryKey = 'id';

    protected $fillable = [
        'id_ujian',
        'id_siswa',
        'id_location',
    ];

    public function detail(){
        return $this->belongsTo(Location::class, 'id_location', 'id');
    }
}
