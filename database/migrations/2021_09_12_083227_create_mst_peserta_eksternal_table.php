<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstPesertaEksternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_peserta_eksternal', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_peserta', 255); // Internal / Eksternal
            $table->string('tipe_peserta', 255); // PNS / Swasta
            $table->string('status_peserta', 255); // Pekerja / Mahasiswa / Pelajar / Umum
            $table->string('NIP', 255)->nullable();
            $table->string('nama_lengkap_peserta', 255);
            $table->string('jabatan', 255)->nullable();
           // $table->string('pangkat', 255)->nullable();
           //$table->string('golongan', 255)->nullable();
            $table->string('satuan_kerja_text', 255)->nullable();
            $table->integer('satuan_kerja_id')->nullable();
            $table->string('instansi', 255);
            $table->string('email', 255);
            $table->string('no_hp', 255);
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('deleted_by', 50)->nullable();
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes($column = 'deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_peserta_eksternal');
    }
}
