<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kegiatan', 50);
            $table->string('jenis_kegiatan', 50);
            $table->string('judul_kegiatan', 1000);
            $table->longText('deskripsi_kegiatan')->nullable();
            $table->timestamp('tgl_mulai');
            $table->timestamp('tgl_selesai');
            $table->longText('lokasi_kegiatan')->nullable();
            $table->string('file_undangan', 1000)->nullable();
            $table->longText('slug');
            $table->boolean('is_narsum')->default('N');
            $table->integer('satuan_kerja_id')->nullable();
            $table->string('satuan_kerja_text', 1000)->nullable();
            $table->string('usernameintra', 10)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('deleted_by', 50)->nullable();
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes($column = 'deleted_at');

            $table->foreignId('user_id'); //Foreign Key Table Users
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_kegiatan');
    }
}
