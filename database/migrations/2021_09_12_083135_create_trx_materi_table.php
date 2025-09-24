<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxMateriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_materi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file', 255);
            $table->string('ekstensi_file', 255)->nullable();
            $table->string('ukuran_file', 255)->nullable();
            $table->string('link_file', 1000);
            $table->string('usernameintra', 10)->nullable();

            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('deleted_by', 50)->nullable();
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes($column = 'deleted_at');

            $table->foreignId('mst_kegiatan_id'); //Foreign Key Table Users
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_materi');
    }
}
