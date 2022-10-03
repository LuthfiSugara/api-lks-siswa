<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ujian');
            $table->integer('id_jenis_soal');
            $table->string('pertanyaan');
            $table->string('pilihan_a')->nullable();
            $table->string('pilihan_b')->nullable();
            $table->string('pilihan_c')->nullable();
            $table->string('pilihan_d')->nullable();
            $table->text('jawaban')->nullable();
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
        Schema::dropIfExists('soal');
    }
}
