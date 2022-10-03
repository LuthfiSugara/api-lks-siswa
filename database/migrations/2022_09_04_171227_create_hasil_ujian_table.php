<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_ujian', function (Blueprint $table) {
            $table->id();
            $table->integer('id_siswa');
            $table->integer('id_ujian');
            $table->integer('id_soal');
            $table->text('jawaban_siswa')->nullable();
            $table->text('koreksi_jawaban')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_soal_siswa');
    }
}
