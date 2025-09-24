<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusPesertaColumnsNotNullToNullableToTrxPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trx_peserta', function (Blueprint $table) {
            //
            $table->string('status_peserta', 255)->nullable()->change(); // Pekerja / Mahasiswa / Pelajar / Umum
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_peserta', function (Blueprint $table) {
            //
            $table->string('status_peserta', 255)->nullable(false)->change();
        });
    }
}
