<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoBuktiAbsenToTrxPesertaTable extends Migration
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
            $table->longText('foto_bukti_absen')->nullable();
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
            $table->dropColumn('foto_bukti_absen');
        });
    }
}
